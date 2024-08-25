# ACF Slideshow for Microsoft Start Integration

## Overview

This code integrates ACF (Advanced Custom Fields) slideshows into WordPress posts, particularly those categorized under "slideshows," and formats the slideshow data to meet Microsoft Start's RSS feed requirements.

For more information on Microsoft Start feed requirements, visit the [Microsoft Partner Hub](https://www.msn.com/en-us/partnerhub/).

## Key Features

- **ACF Slideshow Field Group**:
  - The slideshow fields are shown only on posts within the "slideshows" category.
  - Contains fields for:
    - Slide Title
    - Slide Description
    - Slide Image (Required)
    - Image Credit (Optional)

- **Microsoft Start Compatibility**:
  - Adds the slideshow to the post's content and RSS feed, formatted for Microsoft Start.
  - A minimum of **5 slides** is recommended for better chances of appearing on Microsoft Start.

## Requirements

- **Slideshows Category**: Posts must be categorized as "slideshows" for the ACF fields to be displayed.
- **Image Requirement**: Each slide must include an image for it to appear in both the post and the RSS feed.
- **Five Slides Minimum**: For best results on Microsoft Start, include at least 5 slides in each slideshow.

## Installation

To install, add the necessary code to your WordPress theme's `functions.php` file, or package it into a custom plugin for easier management.

1. **Initialization**:
   - The class verifies if the ACF plugin is active.
   - It sets up the following hooks:
     - **`the_content` hook**: Appends the slideshow to the post's content.
     - **`rss2_item` hook**: Adds the slideshow to the RSS feed, formatted as per Microsoft Start's guidelines.
     - **`rss2_ns` hook**: Ensures the RSS feed includes the required `media` namespace.

2. **Adding the RSS Media Namespace**:
   - The code automatically inserts the necessary `xmlns:media` declaration into the RSS feed.

3. **Adding the Slideshow to RSS**:
   - When a post contains slides, the slideshow is appended to the RSS feed in the required `media` XML format. This includes:
     - Slide Title
     - Slide Description
     - Slide Image (required)
     - Image Credit (optional)

4. **Displaying the Slideshow in Post Content**:
   - The slideshow is displayed on posts under the "slideshows" category, formatted with slide titles, descriptions, and image credits (if applicable).

## Customization

For customization or troubleshooting, contact **me@philiparudy.com** with the subject "Microsoft Start Plugin Help."

## Important Notes

- **Post Requirements**: The ACF fields are only available on posts within the "slideshows" category.
- **Image Requirement**: Ensure every slide has an image, as it's required for the slideshow to appear.
- **Microsoft Start Optimization**: It’s recommended to have at least 5 slides for optimal chances of being featured on Microsoft Start.

## Code Summary

1. **Slideshows Category**: The slideshow fields are displayed only on posts categorized as "slideshows."
2. **RSS Feed Formatting**: The slideshow is formatted to meet Microsoft Start requirements using the correct `media:content`, `media:title`, `media:description`, and `media:credit` tags.
3. **Post Content Display**: The slideshow is appended to the post content, including titles, descriptions, and images.

## Contact Information

If you encounter any issues or have questions, feel free to reach out to **me@philiparudy.com** for assistance.
