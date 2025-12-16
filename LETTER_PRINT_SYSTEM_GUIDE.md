# Letter Print System Guide

## Overview
આ system employee letters અને offer letters print કરવા માટે છે. બધા letters consistent font, size, અને layout સાથે print થાય છે.

---

## Files Structure

### Main Print Files
| File | Purpose |
|------|---------|
| `resources/views/hr/employees/letters/print.blade.php` | Employee letters print (main) |
| `resources/views/hr/hiring/print_offerletter.blade.php` | Hiring offer letter print |

### Letter Templates
| Template | Location |
|----------|----------|
| Joining | `templates/joining.blade.php` |
| Experience | `templates/experience.blade.php` |
| Agreement | `templates/agreement.blade.php` |
| Warning | `templates/warning.blade.php` |
| Increment | `templates/increment.blade.php` |
| Impartiality | `templates/impartiality.blade.php` |
| Offer | `templates/offer.blade.php` |
| Internship Offer | `templates/internship_offer.blade.php` |
| Internship Letter | `templates/internship_letter.blade.php` |
| Salary Certificate | `templates/salary_certificate.blade.php` |

---

## Design Standards

### Font
- **Font Family:** Poppins (Google Fonts)
- **Font Size:** 13px (consistent across all elements)
- **Bold Weight:** 700

### Layout - Ref No. & Date
```html
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px;">
    <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
    <div><b>Date:</b> {{ date('d-m-Y') }}</div>
</div>
```

### Layout - Recipient
```html
<div class="recipient" style="margin-bottom: 12px; font-size: 13px;">
    <div><b>To,</b></div>
    <div>Mr./Ms. Name</div>
    <div>Position</div>
    <div>Address</div>
</div>
```

### Layout - Subject
```html
<div class="subject" style="font-size: 13px;">Subject: Letter Title</div>
```

### Bullet Points Format
- Position & Compensation: `•` (bullet)
- Probation Period: `•` (bullet)
- Salary Structure: `•` (bullet)

---

## Page Break Logic

### Configuration
- **Max Lines Per Page:** 20 lines
- **Header Lines:** 6 (Ref, To, Name, Position, Address, Subject)
- **Signature Lines:** 4 (Sincerely, Sign, Name, Company)
- **Available Body Lines:** 20 - 6 - 4 = 10 lines

### How It Works
1. JavaScript counts all paragraphs (`<p>`), list items (`<li>`), and divs
2. If content exceeds 20 lines, page break occurs
3. 21st line onwards moves to new page
4. Background image repeats on new page
5. Signature moves to last page

### Adjusting Line Limit
In `print.blade.php`, find:
```javascript
const MAX_LINES_PAGE1 = 20;
```
Change `20` to desired number.

---

## Padding Configuration

### Screen View
```css
.letter-content { 
    padding-top: 200px !important;
}
```

### Print View
```css
.letter-content { 
    padding: 200px 30px 200px 30px;
}
```

### Adjusting Space
- **More space from header:** Increase `padding-top`
- **Less space from header:** Decrease `padding-top`
- Recommended range: 160px - 220px

---

## Background Image
- **Location:** `public/letters/back.png`
- **Signature:** `public/letters/signature.png`

---

## Quick Reference - Common Changes

### Change Font Size
Find in CSS:
```css
font-size: 13px;
```
Change to desired size (e.g., `14px`, `12px`)

### Change Line Limit
```javascript
const MAX_LINES_PAGE1 = 20; // Change this number
```

### Change Top Padding (Screen)
```css
@media screen {
    .letter-content { 
        padding-top: 200px !important; // Change this
    }
}
```

### Change Top Padding (Print)
```css
@media print {
    .letter-content { 
        padding: 200px 30px 200px 30px; // First value is top
    }
}
```

---

## Template Header Format (Copy-Paste Ready)

```html
<div class="letter-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px;">
        <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
        <div><b>Date:</b> {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</div>
    </div>
    <div class="recipient" style="margin-bottom: 12px; font-size: 13px;">
        <div><b>To,</b></div>
        <div>{{ ($employee->gender == 'Female') ? 'Ms.' : 'Mr.' }} {{ $employee->name }}</div>
        <div>{{ $employee->designation ?? $employee->position ?? 'Employee' }}</div>
        @if($employee->address)
        <div>{{ $employee->address }}</div>
        @endif
    </div>
</div>

@if($letter->subject)
<div class="subject" style="font-size: 13px;">Subject: {{ $letter->subject }}</div>
@else
<div class="subject" style="font-size: 13px;">Subject: Letter Title Here</div>
@endif
```

---

## Offer Letter Bullet Format (Copy-Paste Ready)

```html
<div style="margin-top:8px;">
    <div style="margin-bottom:6px;"><b>1. Position & Compensation</b></div>
    <div style="margin-left:18px;">
        <div style="margin-bottom:2px;">• <b>Designation:</b> Value</div>
        <div style="margin-bottom:2px;">• <b>Monthly Salary:</b> ₹ Value</div>
        <div style="margin-bottom:2px;">• <b>Annual CTC:</b> ₹ Value</div>
        <div style="margin-bottom:2px;">• <b>Reporting Manager:</b> Value</div>
        <div style="margin-bottom:2px;">• <b>Working Hours:</b> Value</div>
    </div>
    
    <div style="margin-top:8px; margin-bottom:6px;"><b>2. Probation Period</b></div>
    <div style="margin-left:18px;">
        <div style="margin-bottom:2px;">• Point 1</div>
        <div style="margin-bottom:2px;">• Point 2</div>
    </div>
    
    <div style="margin-top:8px; margin-bottom:6px;"><b>3. Salary & Increment Structure</b></div>
    <div style="margin-left:18px;">
        <div style="margin-bottom:2px;">• Point 1</div>
        <div style="margin-bottom:2px;">• Point 2</div>
    </div>
</div>
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Content overlaps header | Increase `padding-top` in screen CSS |
| Too much space above content | Decrease `padding-top` |
| Page break too early | Increase `MAX_LINES_PAGE1` |
| Page break too late | Decrease `MAX_LINES_PAGE1` |
| Font not loading | Check Google Fonts import URL |
| Background not printing | Enable "Background graphics" in print settings |

---

*Last Updated: December 2025*
