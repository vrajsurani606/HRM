# Contract Copy Generation - PDF & PNG

This feature allows you to generate contract copies in both PDF and PNG formats from quotations.

## Installation

1. **Install Required Packages:**
   ```bash
   composer require barryvdh/laravel-dompdf:^3.0
   composer require intervention/image:^3.0
   ```
   
   Or run the provided batch file:
   ```bash
   install-packages.bat
   ```

2. **For PNG Generation (Optional - requires ImageMagick):**
   - Install ImageMagick on your system
   - Enable the `imagick` PHP extension in your `php.ini`
   - If ImageMagick is not available, PNG generation will fallback to PDF

## Features

### PDF Generation
- Professional contract layout
- Company and client information
- Service details and pricing
- Payment terms and conditions
- Digital signatures section
- Automatic formatting and styling

### PNG Generation
- Converts PDF to high-quality PNG image
- 300 DPI resolution for crisp output
- Fallback to PDF if ImageMagick unavailable
- Perfect for sharing via messaging apps

## Usage

### From Quotation Show Page
1. Navigate to any quotation details page
2. Click "Generate PDF Contract" for PDF format
3. Click "Generate PNG Contract" for PNG format

### From Quotations List
1. Go to quotations index page
2. Use the action icons in each row:
   - Print icon: Generate PDF
   - Convert icon: Generate PNG

## File Structure

```
resources/views/quotations/
├── contract-pdf.blade.php    # PDF template
├── show.blade.php           # Updated with generation buttons
└── index.blade.php          # Updated with action buttons

app/Http/Controllers/Quotation/
└── QuotationController.php  # Added generation methods

routes/
└── web.php                  # Added new routes

config/
└── dompdf.php              # PDF generation configuration
```

## Routes Added

- `GET /quotations/{id}/contract-pdf` - Generate PDF contract
- `GET /quotations/{id}/contract-png` - Generate PNG contract

## Customization

### PDF Template
Edit `resources/views/quotations/contract-pdf.blade.php` to customize:
- Layout and styling
- Company branding
- Terms and conditions
- Signature sections

### PDF Settings
Modify `config/dompdf.php` to adjust:
- Paper size and orientation
- Font settings
- Image handling
- Security options

## Troubleshooting

### PDF Generation Issues
- Ensure DomPDF package is installed
- Check file permissions in storage directory
- Verify CSS compatibility (avoid complex layouts)

### PNG Generation Issues
- Install ImageMagick: `sudo apt-get install imagemagick` (Linux)
- Enable PHP extension: `extension=imagick` in php.ini
- Restart web server after changes

### Common Errors
- **Memory limit**: Increase PHP memory_limit in php.ini
- **Timeout**: Increase max_execution_time for large documents
- **Fonts**: Ensure font files are accessible in storage/fonts/

## Security Notes

- Generated files are served directly (not stored permanently)
- Temporary PDF files are cleaned up automatically
- Access is controlled through existing authentication
- No sensitive data is logged during generation

## Performance Tips

- PNG generation is slower than PDF (requires conversion)
- Consider caching for frequently accessed contracts
- Use PDF for bulk operations, PNG for individual sharing
- Monitor server resources during high-volume generation