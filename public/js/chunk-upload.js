/**
 * Chunked File Upload Helper
 * Breaks large files into smaller chunks for upload
 */
class ChunkedUploader {
    constructor(file, options = {}) {
        this.file = file;
        this.options = {
            chunkSize: 2 * 1024 * 1024, // 2MB chunks (match PHP upload_max_filesize)
            endpoint: "/upload-chunk",
            onProgress: (progress) => {},
            onComplete: (response) => {},
            onError: (error) => {},
            ...options,
        };

        this.totalChunks = Math.ceil(this.file.size / this.options.chunkSize);
        this.currentChunk = 0;
        this.uploadId = this.generateUploadId();
    }

    /**
     * Generate a unique ID for this upload
     */
    generateUploadId() {
        return [
            this.file.name,
            this.file.size,
            this.file.lastModified,
            new Date().getTime(),
        ].join("-");
    }

    /**
     * Start the upload process
     */
    start() {
        this.uploadNextChunk();
    }

    /**
     * Upload the next chunk of the file
     */
    uploadNextChunk() {
        if (this.currentChunk >= this.totalChunks) {
            // All chunks uploaded, finalize
            this.finalizeUpload();
            return;
        }

        const start = this.currentChunk * this.options.chunkSize;
        const end = Math.min(start + this.options.chunkSize, this.file.size);
        const chunk = this.file.slice(start, end);

        const formData = new FormData();
        formData.append("file", chunk, this.file.name);
        formData.append("upload_id", this.uploadId);
        formData.append("chunk_index", this.currentChunk);
        formData.append("total_chunks", this.totalChunks);

        fetch(this.options.endpoint, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    this.currentChunk++;

                    // Calculate progress
                    const progress = Math.round(
                        (this.currentChunk / this.totalChunks) * 100
                    );
                    this.options.onProgress(progress);

                    // Upload next chunk
                    this.uploadNextChunk();
                } else {
                    this.options.onError(data.error || "Upload failed");
                }
            })
            .catch((error) => {
                this.options.onError(error.message || "Network error");
            });
    }

    /**
     * Finalize the upload after all chunks are uploaded
     */
    finalizeUpload() {
        const formData = new FormData();
        formData.append("upload_id", this.uploadId);
        formData.append("filename", this.file.name);
        formData.append("total_size", this.file.size);
        formData.append("discourse_id", this.options.discourseId);
        formData.append("title", this.options.title);
        formData.append("sequence", this.options.sequence);
        formData.append("duration_seconds", this.options.duration_seconds);

        fetch(this.options.finalize_endpoint, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    this.options.onComplete(data);
                } else {
                    this.options.onError(
                        data.error || "Failed to finalize upload"
                    );
                }
            })
            .catch((error) => {
                this.options.onError(
                    error.message || "Network error during finalization"
                );
            });
    }
}
