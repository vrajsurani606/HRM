<?php
// Bootstrap Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DigitalCard;
use App\Models\Employee;

// Get card data
$um_id = isset($_GET['um_id']) ? intval($_GET['um_id']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$um_id && !$id) {
    die('Invalid ID');
}

try {
    if ($um_id) {
        $card = DigitalCard::where('employee_id', $um_id)->orWhere('um_id', $um_id)->first();
    } else {
        $card = DigitalCard::find($id);
    }
    
    if (!$card) {
        die('Card not found');
    }
    
    $employee = $card->employee;
    
} catch (Exception $e) {
    die('Error loading card: ' . $e->getMessage());
}

// Process data with proper fallbacks
$previous_roles = is_array($card->previous_roles) ? $card->previous_roles : [];
$education = is_array($card->education) ? $card->education : [];
$certifications = is_array($card->certifications) ? $card->certifications : [];
$gallery = is_array($card->gallery) ? $card->gallery : [];
$achievements = is_array($card->achievements) ? $card->achievements : [];
$languages = is_array($card->languages) ? $card->languages : [];
$projects = is_array($card->projects) ? $card->projects : [];
$skills = !empty($card->skills) ? array_map('trim', explode(',', $card->skills)) : [];
$hobbies = !empty($card->hobbies) ? array_map('trim', explode(',', $card->hobbies)) : [];

// Social links
$socials = [
    'linkedin' => $card->linkedin ?? '',
    'github' => $card->github ?? '',
    'twitter' => $card->twitter ?? '',
    'instagram' => $card->instagram ?? '',
    'facebook' => $card->facebook ?? '',
    'portfolio' => $card->portfolio ?? ''
];

// Profile data with employee fallback
$profile = [
    'name' => $card->full_name ?: ($employee->name ?? 'N/A'),
    'position' => $card->current_position ?: ($employee->position ?? 'N/A'),
    'company' => $card->company_name ?: 'Company Name',
    'email' => $card->email ?: ($employee->email ?? 'N/A'),
    'phone' => $card->phone ?: ($employee->mobile_no ?? 'N/A'),
    'location' => $card->location ?? 'N/A',
    'summary' => $card->summary ?? 'No summary available',
    'experience_years' => $card->years_of_experience ?: $card->experience_years ?: '0',
    'willing_to' => $card->willing_to ?? 'Open to opportunities'
];

// Profile image with proper fallback
$profile_image = 'blank_user.webp';
if (!empty($gallery) && is_array($gallery)) {
    foreach ($gallery as $img) {
        if (file_exists(public_path('storage/' . $img))) {
            $profile_image = 'storage/' . $img;
            break;
        }
    }
} elseif ($employee && $employee->photo_path && file_exists(public_path('storage/' . $employee->photo_path))) {
    $profile_image = 'storage/' . $employee->photo_path;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['name']) ?> - Digital Card</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            color: #2d3748;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: var(--border-radius);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
        }

        .header-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            color: white;
        }

        .profile-header {
            text-align: center;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }

        .profile-name {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .profile-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
        }

        .profile-company {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }

        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin: 2rem 0;
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px) scale(1.1);
            color: white;
        }

        .content-section {
            margin-bottom: 2rem;
            padding: 2rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .skill-tag {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .timeline-item {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .timeline-item:hover {
            transform: translateX(10px);
            background: rgba(255, 255, 255, 0.35);
        }

        .timeline-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.5rem;
        }

        .timeline-company {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .timeline-duration {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .timeline-description {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .contact-info {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            color: white;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 0.25rem;
        }

        .contact-value {
            font-weight: 500;
        }

        .summary-text {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: var(--border-radius);
            overflow: hidden;
            aspect-ratio: 1;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .no-data {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-style: italic;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .profile-name {
                font-size: 2rem;
            }
            
            .profile-title {
                font-size: 1.2rem;
            }
            
            .profile-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .social-links {
                flex-wrap: wrap;
            }
            
            .skills-grid {
                justify-content: center;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }

        .print-btn {
            background: var(--secondary-gradient);
        }

        .download-btn {
            background: var(--accent-gradient);
        }

        @media print {
            .header-actions {
                display: none;
            }
            
            body {
                background: white;
                color: black;
            }
            
            .glass-card {
                background: white;
                border: 1px solid #ddd;
                box-shadow: none;
            }
            
            .profile-name,
            .profile-title,
            .profile-company,
            .section-title,
            .timeline-title,
            .contact-item,
            .summary-text {
                color: black;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Actions -->
        <div class="header-actions">
            <button onclick="window.print()" class="action-btn print-btn">
                <i class="fas fa-print"></i>
                Print Card
            </button>
            <a href="#" onclick="downloadCard()" class="action-btn download-btn">
                <i class="fas fa-download"></i>
                Download
            </a>
        </div>

        <!-- Profile Header -->
        <div class="glass-card profile-header">
            <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile" class="profile-image">
            <h1 class="profile-name"><?= htmlspecialchars($profile['name']) ?></h1>
            <h2 class="profile-title"><?= htmlspecialchars($profile['position']) ?></h2>
            <p class="profile-company"><?= htmlspecialchars($profile['company']) ?></p>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= htmlspecialchars($profile['experience_years']) ?>+</span>
                    <span class="stat-label">Years Experience</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= count($projects) ?></span>
                    <span class="stat-label">Projects</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= count($skills) ?></span>
                    <span class="stat-label">Skills</span>
                </div>
            </div>

            <!-- Social Links -->
            <div class="social-links">
                <?php foreach ($socials as $platform => $url): ?>
                    <?php if (!empty($url)): ?>
                        <a href="<?= htmlspecialchars($url) ?>" target="_blank" class="social-link" title="<?= ucfirst($platform) ?>">
                            <i class="fab fa-<?= $platform === 'portfolio' ? 'globe' : $platform ?>"></i>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Summary Section -->
                <?php if (!empty($profile['summary'])): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        About Me
                    </h3>
                    <p class="summary-text"><?= nl2br(htmlspecialchars($profile['summary'])) ?></p>
                </div>
                <?php endif; ?>

                <!-- Skills Section -->
                <?php if (!empty($skills)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        Skills
                    </h3>
                    <div class="skills-grid">
                        <?php foreach ($skills as $skill): ?>
                            <span class="skill-tag"><?= htmlspecialchars(trim($skill)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Experience Section -->
                <?php if (!empty($previous_roles)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        Experience
                    </h3>
                    <?php foreach ($previous_roles as $role): ?>
                        <div class="timeline-item">
                            <h4 class="timeline-title"><?= htmlspecialchars($role['position'] ?? 'Position') ?></h4>
                            <p class="timeline-company"><?= htmlspecialchars($role['company'] ?? 'Company') ?></p>
                            <p class="timeline-duration"><?= htmlspecialchars($role['duration'] ?? 'Duration') ?></p>
                            <?php if (!empty($role['description'])): ?>
                                <p class="timeline-description"><?= nl2br(htmlspecialchars($role['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Education Section -->
                <?php if (!empty($education)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Education
                    </h3>
                    <?php foreach ($education as $edu): ?>
                        <div class="timeline-item">
                            <h4 class="timeline-title"><?= htmlspecialchars($edu['degree'] ?? 'Degree') ?></h4>
                            <p class="timeline-company"><?= htmlspecialchars($edu['institution'] ?? 'Institution') ?></p>
                            <p class="timeline-duration"><?= htmlspecialchars($edu['year'] ?? 'Year') ?></p>
                            <?php if (!empty($edu['description'])): ?>
                                <p class="timeline-description"><?= nl2br(htmlspecialchars($edu['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Projects Section -->
                <?php if (!empty($projects)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        Projects
                    </h3>
                    <?php foreach ($projects as $project): ?>
                        <div class="timeline-item">
                            <h4 class="timeline-title"><?= htmlspecialchars($project['name'] ?? 'Project Name') ?></h4>
                            <?php if (!empty($project['technologies'])): ?>
                                <p class="timeline-company"><?= htmlspecialchars($project['technologies']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['duration'])): ?>
                                <p class="timeline-duration"><?= htmlspecialchars($project['duration']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['description'])): ?>
                                <p class="timeline-description"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="glass-card contact-info">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-address-card"></i>
                        </div>
                        Contact
                    </h3>
                    
                    <?php if (!empty($profile['email'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Email</div>
                            <div class="contact-value"><?= htmlspecialchars($profile['email']) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($profile['phone'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Phone</div>
                            <div class="contact-value"><?= htmlspecialchars($profile['phone']) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($profile['location'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Location</div>
                            <div class="contact-value"><?= htmlspecialchars($profile['location']) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Languages Section -->
                <?php if (!empty($languages)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-language"></i>
                        </div>
                        Languages
                    </h3>
                    <div class="skills-grid">
                        <?php foreach ($languages as $language): ?>
                            <span class="skill-tag"><?= htmlspecialchars($language['name'] ?? $language) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Hobbies Section -->
                <?php if (!empty($hobbies)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        Hobbies
                    </h3>
                    <div class="skills-grid">
                        <?php foreach ($hobbies as $hobby): ?>
                            <span class="skill-tag"><?= htmlspecialchars(trim($hobby)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Certifications Section -->
                <?php if (!empty($certifications)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        Certifications
                    </h3>
                    <?php foreach ($certifications as $cert): ?>
                        <div class="timeline-item">
                            <h4 class="timeline-title"><?= htmlspecialchars($cert['name'] ?? 'Certification') ?></h4>
                            <?php if (!empty($cert['issuer'])): ?>
                                <p class="timeline-company"><?= htmlspecialchars($cert['issuer']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($cert['date'])): ?>
                                <p class="timeline-duration"><?= htmlspecialchars($cert['date']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Achievements Section -->
                <?php if (!empty($achievements)): ?>
                <div class="glass-card content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        Achievements
                    </h3>
                    <?php foreach ($achievements as $achievement): ?>
                        <div class="timeline-item">
                            <h4 class="timeline-title"><?= htmlspecialchars($achievement['title'] ?? 'Achievement') ?></h4>
                            <?php if (!empty($achievement['description'])): ?>
                                <p class="timeline-description"><?= nl2br(htmlspecialchars($achievement['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Gallery Section -->
        <?php if (!empty($gallery) && count($gallery) > 1): ?>
        <div class="glass-card content-section">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="fas fa-images"></i>
                </div>
                Gallery
            </h3>
            <div class="gallery-grid">
                <?php foreach ($gallery as $image): ?>
                    <?php if (file_exists(public_path('storage/' . $image))): ?>
                        <div class="gallery-item">
                            <img src="storage/<?= htmlspecialchars($image) ?>" alt="Gallery Image" class="gallery-image">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function downloadCard() {
            // Create a temporary link element
            const link = document.createElement('a');
            link.href = window.location.href;
            link.download = '<?= htmlspecialchars($profile['name']) ?>_Digital_Card.html';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>