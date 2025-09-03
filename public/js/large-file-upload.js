/**
 * Large File Upload Handler
 *
 * This script handles large file uploads by submitting them directly
 * to a dedicated endpoint instead of with the main form.
 */
class LargeFileUploader {
    constructor(options = {}) {
        this.options = {
            formSelector: "#discourseForm",
            videoContainerSelector: "#videoContainer",
            uploadEndpoint: "/video-upload", // Fixed endpoint URL to match route
            maxNormalSize: 50 * 1024 * 1024, // 50MB - files larger than this will use direct upload
            csrfToken: document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
            ...options,
        };

        this.form = document.querySelector(this.options.formSelector);
        this.videoContainer = document.querySelector(
            this.options.videoContainerSelector
        );

        if (this.form) {
            this.initFormHandler();
        }
    }

    /**
     * Initialize the form submission handler
     */
    initFormHandler() {
        this.form.addEventListener("submit", this.handleFormSubmit.bind(this));
    }

    /**
     * Handle form submission
     */
    async handleFormSubmit(e) {
        // Find all video file inputs
        const videoItems = this.videoContainer.querySelectorAll(".video-item");
        const largeFiles = [];

        // Check for large files
        videoItems.forEach((item) => {
            const fileInput = item.querySelector(".video-file");
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                const file = fileInput.files[0];

                // If file is larger than the threshold, handle separately
                if (file.size > this.options.maxNormalSize) {
                    largeFiles.push({
                        element: item,
                        file: file,
                        input: fileInput,
                    });
                }
            }
        });

        // If there are large files, handle them separately
        if (largeFiles.length > 0) {
            e.preventDefault(); // Prevent normal form submission

            try {
                // Show loading indicator
                this.showLoadingOverlay("Uploading large video files...");

                // Upload each large file
                for (const item of largeFiles) {
                    await this.uploadLargeFile(item);
                }

                // After all large files are uploaded, submit the form normally
                this.hideLoadingOverlay();
                this.form.submit();
            } catch (error) {
                console.error("Error uploading large files:", error);
                this.hideLoadingOverlay();
                alert(
                    "Error uploading large video files. Please try again or use smaller files."
                );
            }
        }
        // Otherwise, let the form submit normally
    }

    /**
     * Upload a large file directly
     */
    async uploadLargeFile(item) {
        const { element, file, input } = item;

        // Get form data for this video
        const titleInput = element.querySelector(".video-title");
        const sequenceInput = element.querySelector(".video-sequence");

        // Extract discourse ID from URL or form
        let discourseId;
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("discourse")) {
            discourseId = urlParams.get("discourse");
        } else {
            // Try to extract from URL path
            const pathMatch =
                window.location.pathname.match(/\/discourses\/(\d+)/);
            if (pathMatch) {
                discourseId = pathMatch[1];
            } else {
                // Default to a form input if available
                discourseId = document.querySelector(
                    'input[name="discourse_id"]'
                )?.value;
            }
        }

        // Create form data for the upload
        const formData = new FormData();
        formData.append("video_file", file);
        formData.append(
            "title",
            titleInput.value || file.name.replace(/\.[^/.]+$/, "")
        );
        formData.append("sequence", sequenceInput.value || 0);
        formData.append("discourse_id", discourseId);

        // Add CSRF token
        formData.append("_token", this.options.csrfToken);

        // Update progress display
        const progressContainer = element.querySelector(".upload-progress");
        const progressBar = progressContainer.querySelector(".progress-bar");
        const statusText = progressContainer.querySelector(".upload-status");

        progressContainer.style.display = "block";
        statusText.textContent = "Uploading large file...";

        // Simulate progress (since we can't get real progress from the server easily)
        const progressInterval = setInterval(() => {
            const currentWidth = parseInt(progressBar.style.width) || 0;
            if (currentWidth < 90) {
                const newWidth = currentWidth + 1;
                progressBar.style.width = `${newWidth}%`;
                progressBar.setAttribute("aria-valuenow", newWidth);
            }
        }, 1000);

        try {
            console.log("Uploading to:", this.options.uploadEndpoint);

            // Send the upload request
            const response = await fetch(this.options.uploadEndpoint, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": this.options.csrfToken,
                },
            });

            clearInterval(progressInterval);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Upload failed");
            }

            const data = await response.json();
            console.log("Upload response:", data);

            // Update UI to show success
            progressBar.style.width = "100%";
            progressBar.setAttribute("aria-valuenow", 100);
            statusText.textContent = "Upload complete!";

            // Update hidden fields with the uploaded video data
            const videoPathInput = element.querySelector(".video-path");
            const videoFilenameInput = element.querySelector(".video-filename");
            const thumbnailPathInput = element.querySelector(".thumbnail-path");

            if (videoPathInput)
                videoPathInput.value = data.video.video_path || "";
            if (videoFilenameInput)
                videoFilenameInput.value = data.video.video_filename || "";
            if (thumbnailPathInput)
                thumbnailPathInput.value = data.video.thumbnail_path || "";

            // Clear the file input so it doesn't get submitted again
            input.value = "";

            return data;
        } catch (error) {
            console.error("Upload error:", error);
            clearInterval(progressInterval);
            progressBar.style.width = "0%";
            statusText.textContent = "Upload failed: " + error.message;
            throw error;
        }
    }

    /**
     * Show a loading overlay
     */
    showLoadingOverlay(message = "Loading...") {
        const overlay = document.createElement("div");
        overlay.id = "upload-overlay";
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;

        overlay.innerHTML = `
            <div style="background-color: white; padding: 20px; border-radius: 5px; text-align: center;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p style="margin-top: 10px;">${message}</p>
            </div>
        `;

        document.body.appendChild(overlay);
    }

    /**
     * Hide the loading overlay
     */
    hideLoadingOverlay() {
        const overlay = document.getElementById("upload-overlay");
        if (overlay) {
            overlay.remove();
        }
    }
}

// Initialize when the DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    window.largeFileUploader = new LargeFileUploader();
    console.log("Large file uploader initialized");
});
