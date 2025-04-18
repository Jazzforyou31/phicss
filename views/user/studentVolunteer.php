<?php
require_once '../../classes/DatabaseClass.php';

// Initialize Database connection
$db = new Database();
$conn = $db->connect(); // Get the PDO connection

$errors = [];
$success_message = '';
$form_submitted = false; // Flag to toggle form visibility

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $first_name = trim($_POST['first_name']);
    $middle_name = isset($_POST['middle_name']) ? trim($_POST['middle_name']) : null;
    $last_name = trim($_POST['last_name']);
    $school_email = trim($_POST['school_email']);
    $course = trim($_POST['course']);
    $year = trim($_POST['year']);
    $interest = trim($_POST['interest']);
    $program = trim($_POST['program']);
    $status = 'pending';

    // Validation
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($school_email)) {
        $errors[] = "School email is required.";
    } elseif (!filter_var($school_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($course)) $errors[] = "Course is required.";
    if (empty($year)) $errors[] = "Year is required.";
    if (empty($interest)) $errors[] = "Interest is required.";
    if (empty($program)) $errors[] = "Program is required.";

    // Insert into database if no errors
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO volunteers (first_name, middle_name, last_name, school_email, course, year, interest, program, status)
                    VALUES (:first_name, :middle_name, :last_name, :school_email, :course, :year, :interest, :program, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':middle_name', $middle_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':school_email', $school_email);
            $stmt->bindParam(':course', $course);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':interest', $interest);
            $stmt->bindParam(':program', $program);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                $success_message = "Thank you for volunteering! Your information has been saved.";
                $form_submitted = true; // Set flag to true after successful submission
            } else {
                $errors[] = "Failed to save your information.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Volunteer Registration</title>
</head>

<?php include_once '../../includes/header.php'; ?>

<body>

<link rel="stylesheet" href="<?php echo $base_url; ?>css/studentVolunteer.css">

<section class="volunteer-section">
    <div class="container volunteer-container">
        <div class="volunteer-text">
            <h2 class="volunteer-title">Empower Communities, Enrich Lives</h2>
            <p class="volunteer-description">
                Become a catalyst for positive change. Whether you're lending your time, talent, or voice, your involvement plays a pivotal role in building a better tomorrow.
            </p>
            <div class="volunteer-benefits">
                <h3>Why Join Us?</h3>
                <ul>
                    <li>🌱 Cultivate leadership and collaboration</li>
                    <li>🌍 Make a measurable social impact</li>
                    <li>🎓 Enhance your academic and career profile</li>
                    <li>🤝 Be part of a purpose-driven community</li>
                </ul>
            </div>
        </div>
        <div class="volunteer-image">
            <img src="<?php echo $base_url; ?>assets/images/volunteer.png" alt="Volunteering Illustration">
        </div>
    </div>
</section>

<h2 class="form-heading">Volunteer Registration</h2>

<div class="form-wrapper">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>

    <?php if (!$form_submitted): ?>
        <form method="POST" action="studentVolunteer.php" class="styled-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="middle_name">Middle Name (optional)</label>
                    <input type="text" id="middle_name" name="middle_name" value="<?= htmlspecialchars($_POST['middle_name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="school_email">School Email</label>
                    <input type="email" id="school_email" name="school_email" value="<?= htmlspecialchars($_POST['school_email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="course">Course</label>
                    <select id="course" name="course" required>
                        <option value="" disabled <?= empty($_POST['course']) ? 'selected' : '' ?>>Select your course</option>
                        <option value="Computer Science" <?= ($_POST['course'] ?? '') === "Computer Science" ? 'selected' : '' ?>>Computer Science</option>
                        <option value="Information Technology" <?= ($_POST['course'] ?? '') === "Information Technology" ? 'selected' : '' ?>>Information Technology</option>
                        <option value="ACT" <?= ($_POST['course'] ?? '') === "ACT" ? 'selected' : '' ?>>ACT</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="year">Year</label>
                    <select id="year" name="year" required>
                        <option value="" disabled <?= empty($_POST['year']) ? 'selected' : '' ?>>Select your year</option>
                        <option value="1st Year" <?= ($_POST['year'] ?? '') === "1st Year" ? 'selected' : '' ?>>1st Year</option>
                        <option value="2nd Year" <?= ($_POST['year'] ?? '') === "2nd Year" ? 'selected' : '' ?>>2nd Year</option>
                        <option value="3rd Year" <?= ($_POST['year'] ?? '') === "3rd Year" ? 'selected' : '' ?>>3rd Year</option>
                        <option value="4th Year" <?= ($_POST['year'] ?? '') === "4th Year" ? 'selected' : '' ?>>4th Year</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="interest">Interest</label>
                    <select id="interest" name="interest" required>
                        <option value="" disabled <?= empty($_POST['interest']) ? 'selected' : '' ?>>Select interest</option>
                        <option value="art" <?= ($_POST['interest'] ?? '') === "art" ? 'selected' : '' ?>>Art</option>
                        <option value="leadership" <?= ($_POST['interest'] ?? '') === "leadership" ? 'selected' : '' ?>>Leadership</option>
                        <option value="advocacy" <?= ($_POST['interest'] ?? '') === "advocacy" ? 'selected' : '' ?>>Advocacy</option>
                        <option value="technology" <?= ($_POST['interest'] ?? '') === "technology" ? 'selected' : '' ?>>Technology</option>
                        <option value="sports" <?= ($_POST['interest'] ?? '') === "sports" ? 'selected' : '' ?>>Sports</option>
                        <option value="community engagement" <?= ($_POST['interest'] ?? '') === "community engagement" ? 'selected' : '' ?>>Community Engagement</option>
                        <option value="health and wellness" <?= ($_POST['interest'] ?? '') === "health and wellness" ? 'selected' : '' ?>>Health and Wellness</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="program">Program to Join</label>
                    <select id="program" name="program" required>
                        <option value="" disabled <?= empty($_POST['program']) ? 'selected' : '' ?>>Select a program</option>
                        <option value="art project" <?= ($_POST['program'] ?? '') === "art project" ? 'selected' : '' ?>>Art Project</option>
                        <option value="leadership training" <?= ($_POST['program'] ?? '') === "leadership training" ? 'selected' : '' ?>>Leadership Training</option>
                        <option value="environmental campaign" <?= ($_POST['program'] ?? '') === "environmental campaign" ? 'selected' : '' ?>>Environmental Campaign</option>
                        <option value="coding workshop" <?= ($_POST['program'] ?? '') === "coding workshop" ? 'selected' : '' ?>>Coding Workshop</option>
                        <option value="health seminar" <?= ($_POST['program'] ?? '') === "health seminar" ? 'selected' : '' ?>>Health Seminar</option>
                    </select>
                </div>
            </div>

            <div class="form-submit">
                <button type="submit">Submit Registration</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

<?php include_once '../../includes/footer.php'; ?>