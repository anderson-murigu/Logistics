<?php
declare(strict_types=1);

require __DIR__ . '/config.php';

$submitted = false;
$formError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $company = trim((string) ($_POST['company'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
        $formError = 'Please add your name, a valid email, and a short description of your shipment needs.';
    } elseif (database() === null) {
        $formError = 'We could not connect your request right now. Please email hello@zenaragroup.co.ke.';
    } else {
        $statement = database()->prepare(
            'INSERT INTO enquiries (name, email, company, message) VALUES (:name, :email, :company, :message)'
        );
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':company' => $company,
            ':message' => $message,
        ]);
        $submitted = true;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Zenara Group moves cargo, commerce and opportunity across Kenya and East Africa.">
    <title>Zenara Group | Logistics that moves with purpose</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="#top" aria-label="Zenara Group home"><span class="brand-mark">Z</span><span>zenara<span class="brand-dot">.</span></span></a>
        <button class="menu-toggle" aria-label="Open navigation" aria-expanded="false">☰</button>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="#services">Services</a><a href="#approach">Our approach</a><a href="#contact">Contact</a>
            <a class="nav-portal" href="portal/">Employee portal <span>↗</span></a>
        </nav>
    </header>

    <main id="top">
        <section class="hero section-grid">
            <div class="hero-copy reveal">
                <p class="eyebrow"><span></span> East Africa, connected</p>
                <h1>Every move has a <em>next chapter.</em></h1>
                <p class="hero-lead">Zenara makes logistics feel less like a handoff and more like momentum. Reliable freight, thoughtful coordination, and clear visibility from origin to destination.</p>
                <div class="hero-actions"><a class="button button-dark" href="#contact">Plan a shipment <span>↗</span></a><a class="text-link" href="#services">Explore services <span>↓</span></a></div>
                <div class="hero-proof"><strong>12+</strong><span>routes across<br>East Africa</span><strong>98%</strong><span>on-time<br>delivery</span></div>
            </div>
            <div class="hero-visual reveal delay-one">
                <div class="image-frame"><img src="https://images.unsplash.com/photo-1586528116493-da8b3f7f6e4a?auto=format&fit=crop&w=1200&q=85" alt="Cargo containers ready for transport"></div>
                <div class="floating-note"><span class="status-dot"></span><div><strong>Moving now</strong><small>Nairobi → Mombasa</small></div><b>ETA 04:20</b></div>
                <div class="route-line"></div>
            </div>
        </section>

        <section class="marquee" aria-label="Zenara capabilities"><span>Road freight</span><i>✳</i><span>Warehousing</span><i>✳</i><span>Last-mile delivery</span><i>✳</i><span>Trade support</span><i>✳</i><span>Road freight</span></section>

        <section class="services section-grid" id="services">
            <div class="section-intro reveal"><p class="eyebrow"><span></span> What we do</p><h2>Good logistics<br><em>keeps moving.</em></h2><p>From a single urgent parcel to a complex regional supply chain, we build the route around what matters to your business.</p><a class="text-link" href="#contact">Talk to our team <span>↗</span></a></div>
            <div class="service-list reveal delay-one">
                <article class="service-item"><span class="service-number">01</span><div><h3>Road freight</h3><p>Dependable movement across Kenya and the region, with people on the details.</p></div><span class="service-arrow">↗</span></article>
                <article class="service-item"><span class="service-number">02</span><div><h3>Storage & fulfilment</h3><p>Flexible, secure space that keeps your inventory ready for its next destination.</p></div><span class="service-arrow">↗</span></article>
                <article class="service-item"><span class="service-number">03</span><div><h3>Last-mile delivery</h3><p>The final kilometre, handled with the same care as the first.</p></div><span class="service-arrow">↗</span></article>
            </div>
        </section>

        <section class="approach" id="approach"><div class="approach-inner section-grid"><div class="approach-image reveal"><img src="https://images.unsplash.com/photo-1494412651409-8963ce7935a7?auto=format&fit=crop&w=1000&q=85" alt="Warehouse worker preparing a shipment"><span class="image-label">Built for the<br>real world</span></div><div class="approach-copy reveal delay-one"><p class="eyebrow"><span></span> Our approach</p><h2>Calm, clear,<br><em>capable.</em></h2><p>Logistics can be complex. Your experience of it should not be. We combine local knowledge, straightforward communication, and practical technology to make every move feel considered.</p><div class="values"><div><b>01</b><span>We stay curious about your business.</span></div><div><b>02</b><span>We communicate before you need to ask.</span></div><div><b>03</b><span>We take ownership all the way through.</span></div></div></div></div></section>

        <section class="contact section-grid" id="contact"><div class="contact-copy reveal"><p class="eyebrow"><span></span> Start a conversation</p><h2>Let’s get<br><em>things moving.</em></h2><p>Tell us what needs to go where. We’ll come back with a clear route forward.</p><div class="contact-details"><a href="mailto:hello@zenaragroup.co.ke">hello@zenaragroup.co.ke</a><a href="tel:+254700000000">+254 700 000 000</a><span>Nairobi, Kenya</span></div></div><div class="form-wrap reveal delay-one"><?php if ($submitted): ?><div class="form-success"><span>✓</span><h3>Message received.</h3><p>Our team will be in touch shortly.</p></div><?php else: ?><?php if ($formError !== ''): ?><p class="form-error"><?= e($formError) ?></p><?php endif; ?><form method="post" action="#contact"><label>Your name<input type="text" name="name" required></label><label>Work email<input type="email" name="email" required></label><label>Company <span>(optional)</span><input type="text" name="company"></label><label>What are you moving?<textarea name="message" rows="4" required></textarea></label><button class="button button-dark" type="submit">Send enquiry <span>↗</span></button></form><?php endif; ?></div></section>
    </main>
    <footer><a class="brand" href="#top"><span class="brand-mark">Z</span><span>zenara<span class="brand-dot">.</span></span></a><p>Logistics with purpose.</p><span>© <?= date('Y') ?> Zenara Group</span></footer>
    <script src="assets/script.js"></script>
</body>
</html>