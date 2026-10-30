-- =================================================================================
-- SQL SCRIPT: DATA TESTING DEMO BASAKULA LMS (5 PENGAJAR, 25 PELAJAR, 5 KELAS)
-- =================================================================================
-- Kriteria:
--   1. 5 Akun Demo Pengajar (pengajar1@basakula.com s/d pengajar5@basakula.com)
--   2. 25 Akun Demo Pelajar (pelajar1@basakula.com s/d pelajar25@basakula.com)
--   3. Password seluruh akun seragam: password123
--   4. 5 Ruang Kelas (JAWA01 s/d JAWA05), masing-masing berisi 1 Pengajar & 5 Pelajar
--   5. Tiap kelas memiliki Materi PDF ("Materi 1 - Pengenalan Bahasa Jawa" / Minggu 1 - Pengenalan Dasar Bahasa Jawa.pdf)
--   6. Tiap kelas memiliki Ujian ("Ujian Evaluasi Bahasa Jawa") dengan tenggat bulan depan (2026-11-30 23:59:00)
--      mengambil 5 soal dari Bank Soal (Anake asu, Anake kebo, Anak pitik, Anak jaran, Anak kodhok)
-- =================================================================================

SET @teacher_role_id = COALESCE((SELECT id FROM roles WHERE name = 'teacher' LIMIT 1), 2);
SET @student_role_id = COALESCE((SELECT id FROM roles WHERE name = 'student' LIMIT 1), 3);

-- Ambil hash password123 langsung dari akun eksisting (atau fallback hash bcrypt standar untuk password123)
SET @pwd = COALESCE(
    (SELECT password FROM users WHERE email IN ('ivan@staff.basakula', 'guru@sekolah.com', 'siswa@sekolah.com', 'admin@sekolah.com') LIMIT 1),
    '$2y$10$5z2g4gOvkL.T1iS5pcM0zutN7m.reV9ps9LK5ifETWYqD9wx0j5a6'
);

-- Ambil referensi file PDF yang sudah pernah diupload ke database
SET @pdf_name = COALESCE((SELECT original_name FROM classroom_post_attachments WHERE mime_type = 'application/pdf' AND original_name LIKE '%Pengenalan Dasar Bahasa Jawa%' LIMIT 1), 'Minggu 1 - Pengenalan Dasar Bahasa Jawa.pdf');
SET @pdf_path = COALESCE((SELECT file_path FROM classroom_post_attachments WHERE mime_type = 'application/pdf' AND original_name LIKE '%Pengenalan Dasar Bahasa Jawa%' LIMIT 1), 'classrooms/23/posts/9/BYzXTwtRZl1yHvRFF4dfrWecxiYXoHBlah9DPuBw.pdf');
SET @pdf_size = COALESCE((SELECT file_size FROM classroom_post_attachments WHERE mime_type = 'application/pdf' AND original_name LIKE '%Pengenalan Dasar Bahasa Jawa%' LIMIT 1), 480572);
SET @mat_body = '{"total_slides":45,"plain_summary":"Pelajari materi ini baik baik, karena materi ini akan menjadi pondasi untuk Bahasa Jawa kalian","is_ppt":true,"checkpoint":{"question":"Apa itu Bahasa Jawa","options":["Bahasa daerah tradisional yang sering digunakan oleh masyarakat untuk berkomunikasi","Bahasa yang tinggal di Pulau Jawa","Bahasa yang mempelajari perhitungan","Bahasa yang tidak perlu dipelajari"],"correct_index":0,"checkpoint_slide":17}}';
SET @week_titles = '{"1":"Minggu 1 - Pengenalan Dasar Bahasa Jawa","2":"Minggu 2 - Unggah-Ungguh & Kosakata Kewan"}';

-- =================================================================================
-- 1. INSERT / UPDATE 5 AKUN DEMO PENGAJAR
-- =================================================================================
INSERT INTO `users` (`role_id`, `name`, `email`, `user_code`, `status`, `password`, `created_at`, `updated_at`)
VALUES
(@teacher_role_id, 'Pengajar Demo 1', 'pengajar1@basakula.com', 'TCH-DEMO-01', 'active', @pwd, NOW(), NOW()),
(@teacher_role_id, 'Pengajar Demo 2', 'pengajar2@basakula.com', 'TCH-DEMO-02', 'active', @pwd, NOW(), NOW()),
(@teacher_role_id, 'Pengajar Demo 3', 'pengajar3@basakula.com', 'TCH-DEMO-03', 'active', @pwd, NOW(), NOW()),
(@teacher_role_id, 'Pengajar Demo 4', 'pengajar4@basakula.com', 'TCH-DEMO-04', 'active', @pwd, NOW(), NOW()),
(@teacher_role_id, 'Pengajar Demo 5', 'pengajar5@basakula.com', 'TCH-DEMO-05', 'active', @pwd, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `name`       = VALUES(`name`),
    `role_id`    = VALUES(`role_id`),
    `status`     = 'active',
    `password`   = VALUES(`password`),
    `deleted_at` = NULL,
    `updated_at` = NOW();

-- =================================================================================
-- 2. INSERT / UPDATE 25 AKUN DEMO PELAJAR
-- =================================================================================
INSERT INTO `users` (`role_id`, `name`, `email`, `user_code`, `status`, `password`, `created_at`, `updated_at`)
VALUES
(@student_role_id, 'Pelajar Demo 1',  'pelajar1@basakula.com',  'STD-DEMO-01', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 2',  'pelajar2@basakula.com',  'STD-DEMO-02', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 3',  'pelajar3@basakula.com',  'STD-DEMO-03', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 4',  'pelajar4@basakula.com',  'STD-DEMO-04', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 5',  'pelajar5@basakula.com',  'STD-DEMO-05', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 6',  'pelajar6@basakula.com',  'STD-DEMO-06', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 7',  'pelajar7@basakula.com',  'STD-DEMO-07', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 8',  'pelajar8@basakula.com',  'STD-DEMO-08', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 9',  'pelajar9@basakula.com',  'STD-DEMO-09', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 10', 'pelajar10@basakula.com', 'STD-DEMO-10', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 11', 'pelajar11@basakula.com', 'STD-DEMO-11', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 12', 'pelajar12@basakula.com', 'STD-DEMO-12', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 13', 'pelajar13@basakula.com', 'STD-DEMO-13', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 14', 'pelajar14@basakula.com', 'STD-DEMO-14', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 15', 'pelajar15@basakula.com', 'STD-DEMO-15', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 16', 'pelajar16@basakula.com', 'STD-DEMO-16', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 17', 'pelajar17@basakula.com', 'STD-DEMO-17', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 18', 'pelajar18@basakula.com', 'STD-DEMO-18', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 19', 'pelajar19@basakula.com', 'STD-DEMO-19', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 20', 'pelajar20@basakula.com', 'STD-DEMO-20', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 21', 'pelajar21@basakula.com', 'STD-DEMO-21', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 22', 'pelajar22@basakula.com', 'STD-DEMO-22', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 23', 'pelajar23@basakula.com', 'STD-DEMO-23', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 24', 'pelajar24@basakula.com', 'STD-DEMO-24', 'active', @pwd, NOW(), NOW()),
(@student_role_id, 'Pelajar Demo 25', 'pelajar25@basakula.com', 'STD-DEMO-25', 'active', @pwd, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `name`       = VALUES(`name`),
    `role_id`    = VALUES(`role_id`),
    `status`     = 'active',
    `password`   = VALUES(`password`),
    `deleted_at` = NULL,
    `updated_at` = NOW();

-- =================================================================================
-- KELAS 1: Kelas Bahasa Jawa A (JAWA01)
-- =================================================================================
SET @t_id = (SELECT id FROM users WHERE email = 'pengajar1@basakula.com' LIMIT 1);

-- Pastikan 5 soal Bank Soal tersedia untuk Pengajar Demo 1
INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, '1. Anake asu diarani apa?', '1. Anake asu diarani apa?', 'umum', '["Meri","Kirik","Gudel","Piyik"]', '[0,100,0,0]', 1, '1', 20, 1, 'Asu berarti anjing, sedangkan kirik berarti anak anjing.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = '1. Anake asu diarani apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan kanggo anake kebo?', 'Apa sebutan kanggo anake kebo?', 'umum', '["Belo","Pricil","Gudel","Cemeng"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan kanggo anake kebo?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak pitik (ayam) disebut apa?', 'Anak pitik (ayam) disebut apa?', 'umum', '["Kuthuk","Genjik","Kirik","Meri"]', '[100,0,0,0]', 0, '0', 20, 1, 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak pitik (ayam) disebut apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan untuk anak jaran (kuda)?', 'Apa sebutan untuk anak jaran (kuda)?', 'umum', '["Piyik","Belo","Nener","Precil"]', '[0,100,0,0]', 1, '1', 20, 1, 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan untuk anak jaran (kuda)?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak kodhok (katak) disebut apa?', 'Anak kodhok (katak) disebut apa?', 'umum', '["Meri","Gudel","Precil","Kuthuk"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak kodhok (katak) disebut apa?');

-- Buat Ruang Kelas JAWA01
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `week_titles`, `created_at`, `updated_at`)
VALUES (@t_id, 'Kelas Bahasa Jawa A', 'Bahasa Jawa Dasar & Unggah-Ungguh', 'JAWA01', 'Ruang kelas pengujian Bahasa Jawa A yang diampu oleh Pengajar Demo 1.', '#16402E', 'fa-book-open', 'active', @week_titles, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `teacher_id` = @t_id,
    `name`       = VALUES(`name`),
    `status`     = 'active',
    `deleted_at` = NULL,
    `updated_at` = NOW();

SET @c_id = (SELECT id FROM classrooms WHERE code = 'JAWA01' LIMIT 1);

-- Masukkan 1 Pengajar ke classroom_members
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, @t_id, 'teacher', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar1@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar2@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar3@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar4@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar5@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
-- Buat Postingan Materi PDF di Kelas JAWA01
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'material', 'Materi 1 - Pengenalan Bahasa Jawa', @mat_body, 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL);

SET @mat_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `classroom_post_attachments` (`post_id`, `original_name`, `file_path`, `file_size`, `mime_type`, `created_at`, `updated_at`)
SELECT @mat_post_id, @pdf_name, @pdf_path, @pdf_size, 'application/pdf', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_post_attachments` WHERE `post_id` = @mat_post_id AND `deleted_at` IS NULL);

-- Buat Postingan Ujian Evaluasi (Tenggat Bulan Depan: 2026-11-30 23:59:00)
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'quiz', 'Ujian Evaluasi Bahasa Jawa - Kelas A', 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas A' AND `deleted_at` IS NULL);

SET @quiz_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas A' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `quiz_masters` (`title`, `slug`, `description`, `time_limit_seconds`, `category`, `is_active`, `created_at`, `updated_at`)
SELECT 'Ujian Evaluasi Bahasa Jawa - Kelas A', 'ujian-evaluasi-bahasa-jawa-kelas-a', 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.', 1800, 'classroom', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-a');

SET @qm_id = (SELECT id FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-a' LIMIT 1);

-- Tautkan 5 Soal Bank Soal ke Ujian Kelas JAWA01
INSERT IGNORE INTO `quiz_question_items` (`quiz_master_id`, `quiz_question_id`, `order_number`, `created_at`, `updated_at`)
SELECT @qm_id, q.id, 1, NOW(), NOW() FROM `quiz_questions` q WHERE q.teacher_id = @t_id ORDER BY q.id ASC LIMIT 5;

INSERT INTO `classroom_quizzes` (`post_id`, `quiz_master_id`, `due_date`, `duration_minutes`, `max_score`, `show_score`, `show_explanation`, `max_attempts`, `instructions`, `created_at`, `updated_at`)
SELECT @quiz_post_id, @qm_id, '2026-11-30 23:59:00', 30, 100, 1, 1, 1, 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_quizzes` WHERE `post_id` = @quiz_post_id AND `deleted_at` IS NULL);

-- =================================================================================
-- KELAS 2: Kelas Bahasa Jawa B (JAWA02)
-- =================================================================================
SET @t_id = (SELECT id FROM users WHERE email = 'pengajar2@basakula.com' LIMIT 1);

-- Pastikan 5 soal Bank Soal tersedia untuk Pengajar Demo 2
INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, '1. Anake asu diarani apa?', '1. Anake asu diarani apa?', 'umum', '["Meri","Kirik","Gudel","Piyik"]', '[0,100,0,0]', 1, '1', 20, 1, 'Asu berarti anjing, sedangkan kirik berarti anak anjing.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = '1. Anake asu diarani apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan kanggo anake kebo?', 'Apa sebutan kanggo anake kebo?', 'umum', '["Belo","Pricil","Gudel","Cemeng"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan kanggo anake kebo?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak pitik (ayam) disebut apa?', 'Anak pitik (ayam) disebut apa?', 'umum', '["Kuthuk","Genjik","Kirik","Meri"]', '[100,0,0,0]', 0, '0', 20, 1, 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak pitik (ayam) disebut apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan untuk anak jaran (kuda)?', 'Apa sebutan untuk anak jaran (kuda)?', 'umum', '["Piyik","Belo","Nener","Precil"]', '[0,100,0,0]', 1, '1', 20, 1, 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan untuk anak jaran (kuda)?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak kodhok (katak) disebut apa?', 'Anak kodhok (katak) disebut apa?', 'umum', '["Meri","Gudel","Precil","Kuthuk"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak kodhok (katak) disebut apa?');

-- Buat Ruang Kelas JAWA02
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `week_titles`, `created_at`, `updated_at`)
VALUES (@t_id, 'Kelas Bahasa Jawa B', 'Bahasa Jawa Dasar & Unggah-Ungguh', 'JAWA02', 'Ruang kelas pengujian Bahasa Jawa B yang diampu oleh Pengajar Demo 2.', '#1E3A8A', 'fa-book-open', 'active', @week_titles, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `teacher_id` = @t_id,
    `name`       = VALUES(`name`),
    `status`     = 'active',
    `deleted_at` = NULL,
    `updated_at` = NOW();

SET @c_id = (SELECT id FROM classrooms WHERE code = 'JAWA02' LIMIT 1);

-- Masukkan 1 Pengajar ke classroom_members
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, @t_id, 'teacher', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar6@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar7@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar8@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar9@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar10@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
-- Buat Postingan Materi PDF di Kelas JAWA02
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'material', 'Materi 1 - Pengenalan Bahasa Jawa', @mat_body, 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL);

SET @mat_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `classroom_post_attachments` (`post_id`, `original_name`, `file_path`, `file_size`, `mime_type`, `created_at`, `updated_at`)
SELECT @mat_post_id, @pdf_name, @pdf_path, @pdf_size, 'application/pdf', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_post_attachments` WHERE `post_id` = @mat_post_id AND `deleted_at` IS NULL);

-- Buat Postingan Ujian Evaluasi (Tenggat Bulan Depan: 2026-11-30 23:59:00)
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'quiz', 'Ujian Evaluasi Bahasa Jawa - Kelas B', 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas B' AND `deleted_at` IS NULL);

SET @quiz_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas B' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `quiz_masters` (`title`, `slug`, `description`, `time_limit_seconds`, `category`, `is_active`, `created_at`, `updated_at`)
SELECT 'Ujian Evaluasi Bahasa Jawa - Kelas B', 'ujian-evaluasi-bahasa-jawa-kelas-b', 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.', 1800, 'classroom', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-b');

SET @qm_id = (SELECT id FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-b' LIMIT 1);

-- Tautkan 5 Soal Bank Soal ke Ujian Kelas JAWA02
INSERT IGNORE INTO `quiz_question_items` (`quiz_master_id`, `quiz_question_id`, `order_number`, `created_at`, `updated_at`)
SELECT @qm_id, q.id, 1, NOW(), NOW() FROM `quiz_questions` q WHERE q.teacher_id = @t_id ORDER BY q.id ASC LIMIT 5;

INSERT INTO `classroom_quizzes` (`post_id`, `quiz_master_id`, `due_date`, `duration_minutes`, `max_score`, `show_score`, `show_explanation`, `max_attempts`, `instructions`, `created_at`, `updated_at`)
SELECT @quiz_post_id, @qm_id, '2026-11-30 23:59:00', 30, 100, 1, 1, 1, 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_quizzes` WHERE `post_id` = @quiz_post_id AND `deleted_at` IS NULL);

-- =================================================================================
-- KELAS 3: Kelas Bahasa Jawa C (JAWA03)
-- =================================================================================
SET @t_id = (SELECT id FROM users WHERE email = 'pengajar3@basakula.com' LIMIT 1);

-- Pastikan 5 soal Bank Soal tersedia untuk Pengajar Demo 3
INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, '1. Anake asu diarani apa?', '1. Anake asu diarani apa?', 'umum', '["Meri","Kirik","Gudel","Piyik"]', '[0,100,0,0]', 1, '1', 20, 1, 'Asu berarti anjing, sedangkan kirik berarti anak anjing.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = '1. Anake asu diarani apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan kanggo anake kebo?', 'Apa sebutan kanggo anake kebo?', 'umum', '["Belo","Pricil","Gudel","Cemeng"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan kanggo anake kebo?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak pitik (ayam) disebut apa?', 'Anak pitik (ayam) disebut apa?', 'umum', '["Kuthuk","Genjik","Kirik","Meri"]', '[100,0,0,0]', 0, '0', 20, 1, 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak pitik (ayam) disebut apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan untuk anak jaran (kuda)?', 'Apa sebutan untuk anak jaran (kuda)?', 'umum', '["Piyik","Belo","Nener","Precil"]', '[0,100,0,0]', 1, '1', 20, 1, 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan untuk anak jaran (kuda)?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak kodhok (katak) disebut apa?', 'Anak kodhok (katak) disebut apa?', 'umum', '["Meri","Gudel","Precil","Kuthuk"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak kodhok (katak) disebut apa?');

-- Buat Ruang Kelas JAWA03
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `week_titles`, `created_at`, `updated_at`)
VALUES (@t_id, 'Kelas Bahasa Jawa C', 'Bahasa Jawa Dasar & Unggah-Ungguh', 'JAWA03', 'Ruang kelas pengujian Bahasa Jawa C yang diampu oleh Pengajar Demo 3.', '#7C2D12', 'fa-book-open', 'active', @week_titles, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `teacher_id` = @t_id,
    `name`       = VALUES(`name`),
    `status`     = 'active',
    `deleted_at` = NULL,
    `updated_at` = NOW();

SET @c_id = (SELECT id FROM classrooms WHERE code = 'JAWA03' LIMIT 1);

-- Masukkan 1 Pengajar ke classroom_members
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, @t_id, 'teacher', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar11@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar12@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar13@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar14@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar15@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
-- Buat Postingan Materi PDF di Kelas JAWA03
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'material', 'Materi 1 - Pengenalan Bahasa Jawa', @mat_body, 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL);

SET @mat_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `classroom_post_attachments` (`post_id`, `original_name`, `file_path`, `file_size`, `mime_type`, `created_at`, `updated_at`)
SELECT @mat_post_id, @pdf_name, @pdf_path, @pdf_size, 'application/pdf', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_post_attachments` WHERE `post_id` = @mat_post_id AND `deleted_at` IS NULL);

-- Buat Postingan Ujian Evaluasi (Tenggat Bulan Depan: 2026-11-30 23:59:00)
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'quiz', 'Ujian Evaluasi Bahasa Jawa - Kelas C', 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas C' AND `deleted_at` IS NULL);

SET @quiz_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas C' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `quiz_masters` (`title`, `slug`, `description`, `time_limit_seconds`, `category`, `is_active`, `created_at`, `updated_at`)
SELECT 'Ujian Evaluasi Bahasa Jawa - Kelas C', 'ujian-evaluasi-bahasa-jawa-kelas-c', 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.', 1800, 'classroom', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-c');

SET @qm_id = (SELECT id FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-c' LIMIT 1);

-- Tautkan 5 Soal Bank Soal ke Ujian Kelas JAWA03
INSERT IGNORE INTO `quiz_question_items` (`quiz_master_id`, `quiz_question_id`, `order_number`, `created_at`, `updated_at`)
SELECT @qm_id, q.id, 1, NOW(), NOW() FROM `quiz_questions` q WHERE q.teacher_id = @t_id ORDER BY q.id ASC LIMIT 5;

INSERT INTO `classroom_quizzes` (`post_id`, `quiz_master_id`, `due_date`, `duration_minutes`, `max_score`, `show_score`, `show_explanation`, `max_attempts`, `instructions`, `created_at`, `updated_at`)
SELECT @quiz_post_id, @qm_id, '2026-11-30 23:59:00', 30, 100, 1, 1, 1, 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_quizzes` WHERE `post_id` = @quiz_post_id AND `deleted_at` IS NULL);

-- =================================================================================
-- KELAS 4: Kelas Bahasa Jawa D (JAWA04)
-- =================================================================================
SET @t_id = (SELECT id FROM users WHERE email = 'pengajar4@basakula.com' LIMIT 1);

-- Pastikan 5 soal Bank Soal tersedia untuk Pengajar Demo 4
INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, '1. Anake asu diarani apa?', '1. Anake asu diarani apa?', 'umum', '["Meri","Kirik","Gudel","Piyik"]', '[0,100,0,0]', 1, '1', 20, 1, 'Asu berarti anjing, sedangkan kirik berarti anak anjing.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = '1. Anake asu diarani apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan kanggo anake kebo?', 'Apa sebutan kanggo anake kebo?', 'umum', '["Belo","Pricil","Gudel","Cemeng"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan kanggo anake kebo?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak pitik (ayam) disebut apa?', 'Anak pitik (ayam) disebut apa?', 'umum', '["Kuthuk","Genjik","Kirik","Meri"]', '[100,0,0,0]', 0, '0', 20, 1, 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak pitik (ayam) disebut apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan untuk anak jaran (kuda)?', 'Apa sebutan untuk anak jaran (kuda)?', 'umum', '["Piyik","Belo","Nener","Precil"]', '[0,100,0,0]', 1, '1', 20, 1, 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan untuk anak jaran (kuda)?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak kodhok (katak) disebut apa?', 'Anak kodhok (katak) disebut apa?', 'umum', '["Meri","Gudel","Precil","Kuthuk"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak kodhok (katak) disebut apa?');

-- Buat Ruang Kelas JAWA04
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `week_titles`, `created_at`, `updated_at`)
VALUES (@t_id, 'Kelas Bahasa Jawa D', 'Bahasa Jawa Dasar & Unggah-Ungguh', 'JAWA04', 'Ruang kelas pengujian Bahasa Jawa D yang diampu oleh Pengajar Demo 4.', '#581C87', 'fa-book-open', 'active', @week_titles, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `teacher_id` = @t_id,
    `name`       = VALUES(`name`),
    `status`     = 'active',
    `deleted_at` = NULL,
    `updated_at` = NOW();

SET @c_id = (SELECT id FROM classrooms WHERE code = 'JAWA04' LIMIT 1);

-- Masukkan 1 Pengajar ke classroom_members
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, @t_id, 'teacher', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar16@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar17@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar18@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar19@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar20@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
-- Buat Postingan Materi PDF di Kelas JAWA04
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'material', 'Materi 1 - Pengenalan Bahasa Jawa', @mat_body, 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL);

SET @mat_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `classroom_post_attachments` (`post_id`, `original_name`, `file_path`, `file_size`, `mime_type`, `created_at`, `updated_at`)
SELECT @mat_post_id, @pdf_name, @pdf_path, @pdf_size, 'application/pdf', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_post_attachments` WHERE `post_id` = @mat_post_id AND `deleted_at` IS NULL);

-- Buat Postingan Ujian Evaluasi (Tenggat Bulan Depan: 2026-11-30 23:59:00)
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'quiz', 'Ujian Evaluasi Bahasa Jawa - Kelas D', 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas D' AND `deleted_at` IS NULL);

SET @quiz_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas D' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `quiz_masters` (`title`, `slug`, `description`, `time_limit_seconds`, `category`, `is_active`, `created_at`, `updated_at`)
SELECT 'Ujian Evaluasi Bahasa Jawa - Kelas D', 'ujian-evaluasi-bahasa-jawa-kelas-d', 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.', 1800, 'classroom', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-d');

SET @qm_id = (SELECT id FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-d' LIMIT 1);

-- Tautkan 5 Soal Bank Soal ke Ujian Kelas JAWA04
INSERT IGNORE INTO `quiz_question_items` (`quiz_master_id`, `quiz_question_id`, `order_number`, `created_at`, `updated_at`)
SELECT @qm_id, q.id, 1, NOW(), NOW() FROM `quiz_questions` q WHERE q.teacher_id = @t_id ORDER BY q.id ASC LIMIT 5;

INSERT INTO `classroom_quizzes` (`post_id`, `quiz_master_id`, `due_date`, `duration_minutes`, `max_score`, `show_score`, `show_explanation`, `max_attempts`, `instructions`, `created_at`, `updated_at`)
SELECT @quiz_post_id, @qm_id, '2026-11-30 23:59:00', 30, 100, 1, 1, 1, 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_quizzes` WHERE `post_id` = @quiz_post_id AND `deleted_at` IS NULL);

-- =================================================================================
-- KELAS 5: Kelas Bahasa Jawa E (JAWA05)
-- =================================================================================
SET @t_id = (SELECT id FROM users WHERE email = 'pengajar5@basakula.com' LIMIT 1);

-- Pastikan 5 soal Bank Soal tersedia untuk Pengajar Demo 5
INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, '1. Anake asu diarani apa?', '1. Anake asu diarani apa?', 'umum', '["Meri","Kirik","Gudel","Piyik"]', '[0,100,0,0]', 1, '1', 20, 1, 'Asu berarti anjing, sedangkan kirik berarti anak anjing.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = '1. Anake asu diarani apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan kanggo anake kebo?', 'Apa sebutan kanggo anake kebo?', 'umum', '["Belo","Pricil","Gudel","Cemeng"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kebo berarti kerbau. Anak kerbau disebut gudel dalam Bahasa Jawa.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan kanggo anake kebo?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak pitik (ayam) disebut apa?', 'Anak pitik (ayam) disebut apa?', 'umum', '["Kuthuk","Genjik","Kirik","Meri"]', '[100,0,0,0]', 0, '0', 20, 1, 'Pitik berarti ayam, sedangkan kuthuk merupakan sebutan untuk anak ayam.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak pitik (ayam) disebut apa?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Apa sebutan untuk anak jaran (kuda)?', 'Apa sebutan untuk anak jaran (kuda)?', 'umum', '["Piyik","Belo","Nener","Precil"]', '[0,100,0,0]', 1, '1', 20, 1, 'Dalam Bahasa Jawa, jaran berarti kuda dan belo berarti anak kuda.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Apa sebutan untuk anak jaran (kuda)?');

INSERT INTO `quiz_questions` (`teacher_id`, `question`, `question_text`, `category`, `options`, `option_percentages`, `correct_index`, `correct_answer`, `points`, `is_active`, `explanation`, `created_at`, `updated_at`)
SELECT @t_id, 'Anak kodhok (katak) disebut apa?', 'Anak kodhok (katak) disebut apa?', 'umum', '["Meri","Gudel","Precil","Kuthuk"]', '[0,0,100,0]', 2, '2', 20, 1, 'Kodhok berarti katak. Dalam kosakata Bahasa Jawa, precil merupakan sebutan untuk anak katak.', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_questions` WHERE `teacher_id` = @t_id AND `question` = 'Anak kodhok (katak) disebut apa?');

-- Buat Ruang Kelas JAWA05
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `week_titles`, `created_at`, `updated_at`)
VALUES (@t_id, 'Kelas Bahasa Jawa E', 'Bahasa Jawa Dasar & Unggah-Ungguh', 'JAWA05', 'Ruang kelas pengujian Bahasa Jawa E yang diampu oleh Pengajar Demo 5.', '#0F766E', 'fa-book-open', 'active', @week_titles, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `teacher_id` = @t_id,
    `name`       = VALUES(`name`),
    `status`     = 'active',
    `deleted_at` = NULL,
    `updated_at` = NOW();

SET @c_id = (SELECT id FROM classrooms WHERE code = 'JAWA05' LIMIT 1);

-- Masukkan 1 Pengajar ke classroom_members
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, @t_id, 'teacher', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar21@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar22@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar23@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar24@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `out_at`, `created_at`, `updated_at`)
VALUES (@c_id, (SELECT id FROM users WHERE email = 'pelajar25@basakula.com' LIMIT 1), 'student', NOW(), NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL, `updated_at` = NOW();
-- Buat Postingan Materi PDF di Kelas JAWA05
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'material', 'Materi 1 - Pengenalan Bahasa Jawa', @mat_body, 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL);

SET @mat_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'material' AND `title` = 'Materi 1 - Pengenalan Bahasa Jawa' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `classroom_post_attachments` (`post_id`, `original_name`, `file_path`, `file_size`, `mime_type`, `created_at`, `updated_at`)
SELECT @mat_post_id, @pdf_name, @pdf_path, @pdf_size, 'application/pdf', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_post_attachments` WHERE `post_id` = @mat_post_id AND `deleted_at` IS NULL);

-- Buat Postingan Ujian Evaluasi (Tenggat Bulan Depan: 2026-11-30 23:59:00)
INSERT INTO `classroom_posts` (`classroom_id`, `author_id`, `type`, `title`, `body`, `week_number`, `is_published`, `created_at`, `updated_at`)
SELECT @c_id, @t_id, 'quiz', 'Ujian Evaluasi Bahasa Jawa - Kelas E', 'Ujian evaluasi pemahaman materi dasar Bahasa Jawa dan kosakata arane anak kewan. Silakan kerjakan sebelum batas waktu berakhir.', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas E' AND `deleted_at` IS NULL);

SET @quiz_post_id = (SELECT id FROM `classroom_posts` WHERE `classroom_id` = @c_id AND `type` = 'quiz' AND `title` = 'Ujian Evaluasi Bahasa Jawa - Kelas E' AND `deleted_at` IS NULL LIMIT 1);

INSERT INTO `quiz_masters` (`title`, `slug`, `description`, `time_limit_seconds`, `category`, `is_active`, `created_at`, `updated_at`)
SELECT 'Ujian Evaluasi Bahasa Jawa - Kelas E', 'ujian-evaluasi-bahasa-jawa-kelas-e', 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan.', 1800, 'classroom', 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-e');

SET @qm_id = (SELECT id FROM `quiz_masters` WHERE `slug` = 'ujian-evaluasi-bahasa-jawa-kelas-e' LIMIT 1);

-- Tautkan 5 Soal Bank Soal ke Ujian Kelas JAWA05
INSERT IGNORE INTO `quiz_question_items` (`quiz_master_id`, `quiz_question_id`, `order_number`, `created_at`, `updated_at`)
SELECT @qm_id, q.id, 1, NOW(), NOW() FROM `quiz_questions` q WHERE q.teacher_id = @t_id ORDER BY q.id ASC LIMIT 5;

INSERT INTO `classroom_quizzes` (`post_id`, `quiz_master_id`, `due_date`, `duration_minutes`, `max_score`, `show_score`, `show_explanation`, `max_attempts`, `instructions`, `created_at`, `updated_at`)
SELECT @quiz_post_id, @qm_id, '2026-11-30 23:59:00', 30, 100, 1, 1, 1, 'Kalian diperbolehkan untuk membuka materi yang sudah diberikan. Pilihlah jawaban yang paling tepat!', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `classroom_quizzes` WHERE `post_id` = @quiz_post_id AND `deleted_at` IS NULL);
