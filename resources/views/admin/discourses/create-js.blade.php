<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor for description
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });

    // Thumbnail preview
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContent = document.querySelector('.preview-content');

    thumbnailInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `<img src="${e.target.result}" alt="Thumbnail Preview">`;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            previewContent.innerHTML = `
                <div class="preview-placeholder">
                    <i class="fas fa-image fa-3x"></i>
                </div>
            `;
        }
    });

    // Toggle expected release date based on is_upcoming
    const isUpcomingCheckbox = document.getElementById('is_upcoming');
    const releaseDateContainer = document.getElementById('expected-release-date-container');

    isUpcomingCheckbox.addEventListener('change', function() {
        releaseDateContainer.style.display = this.checked ? 'block' : 'none';
    });

    // Generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('blur', function() {
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
        }
    });

    // Video handling
    let videoIndex = 0;
    const videoContainer = document.getElementById('videoContainer');
    const videoTemplate = document.getElementById('videoTemplate').innerHTML;
    const addVideoBtn = document.getElementById('addVideoBtn');

    // Add video
    addVideoBtn.addEventListener('click', function() {
        const newVideo = videoTemplate.replace(/__INDEX__/g, videoIndex);
        const videoDiv = document.createElement('div');
        videoDiv.innerHTML = newVideo;
        videoContainer.appendChild(videoDiv.firstElementChild);

        // Initialize the video upload wrapper
        const uploadWrapper = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .video-upload-wrapper`);
        const fileInput = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .video-file`);
        
        uploadWrapper.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const fileSize = this.files[0].size;
                const formattedSize = (fileSize / (1024 * 1024)).toFixed(2) + ' MB';
                
                const videoItem = this.closest('.video-item');
                const titleInput = videoItem.querySelector('.video-title');
                const videoPreview = videoItem.querySelector('.video-preview');
                
                // Set title if empty
                if (!titleInput.value) {
                    titleInput.value = fileName.split('.').slice(0, -1).join('.');
                }
                
                // Update preview
                videoPreview.innerHTML = `
                    <i class="fas fa-play play-icon"></i>
                    <div class="position-absolute bottom-0 start-0 end-0 p-2 bg-dark bg-opacity-50 text-white small">
                        ${fileName} (${formattedSize})
                    </div>
                `;
                
                // Store file info
                videoItem.querySelector('.video-filename').value = fileName;
                videoItem.querySelector('.mime-type').value = this.files[0].type;
                videoItem.querySelector('.file-size').value = fileSize;
            }
        });

        // Remove video
        const removeBtn = videoContainer.querySelector(`.video-item[data-index="${videoIndex}"] .remove-video`);
        removeBtn.addEventListener('click', function() {
            this.closest('.video-item').remove();
        });

        videoIndex++;
    });

    // Form validation
    const discourseForm = document.getElementById('discourseForm');
    discourseForm.addEventListener('submit', function(event) {
        // Basic validation
        const title = document.getElementById('title').value;
        const description = document.querySelector('.ck-editor__editable').innerHTML;
        
        let isValid = true;
        
        if (!title.trim()) {
            document.getElementById('title').classList.add('is-invalid');
            isValid = false;
        }
        
        if (!description.trim() || description === '<p>&nbsp;</p>') {
            document.getElementById('description-error').style.display = 'block';
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
        }
    });
});
</script>