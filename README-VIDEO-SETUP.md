# Video Upload and Streaming Setup Guide

This guide explains how to set up the video upload and streaming functionality in the application.

## Prerequisites

### Storage Configuration

Ensure your storage is properly configured:

1. Make sure the symbolic link from `public/storage` to `storage/app/public` exists:

```bash
php artisan storage:link
```

2. Set proper permissions on the storage directory:

```bash
chmod -R 775 storage
chown -R www-data:www-data storage  # Use your web server user
```

3. Update your `.env` file to use the correct disk:

```
FILESYSTEM_DISK=public
```

### PHP Configuration

For uploading large video files, you need to increase PHP limits:

1. In your `php.ini` file:

```ini
upload_max_filesize = 1024M
post_max_size = 1024M
memory_limit = 1024M
max_execution_time = 600
max_input_time = 600
```

2. Alternatively, use `.htaccess` (for Apache) or `.user.ini` (for PHP-FPM):

```
# Already configured in public/.htaccess and public/.user.ini
```

## Video Access Control

The system handles video access control as follows:

1. **Free Videos**: Served directly from `public/storage/videos/...`
2. **Paid Videos**: Served through a secure controller that checks purchase status before streaming

## Video.js Integration

The application uses Video.js for video playback. The necessary files are already included in the layout.

## Testing Video Upload

1. Go to the admin panel and create a new discourse
2. Add a video by clicking "Add Video"
3. Upload a video file (supported formats: MP4, MOV, AVI, WMV)
4. The video will be stored directly without processing
5. Save the discourse to complete the process

## Troubleshooting

### Video Upload Fails

1. Check PHP memory limit and upload size limits in `php.ini`:

```
upload_max_filesize = 1024M
post_max_size = 1024M
memory_limit = 1024M
max_execution_time = 600
```

2. Check storage directory permissions
3. Check if the storage link is created correctly

### Video Playback Issues

1. Ensure the video format is supported by the browser
2. Check browser console for errors
3. Verify the video file exists in the storage directory

## Security Considerations

1. All uploaded videos are stored in the `storage/app/public/videos` directory
2. Paid videos are served through a secure controller that checks user purchase status
3. Video URLs for paid content are not directly accessible
