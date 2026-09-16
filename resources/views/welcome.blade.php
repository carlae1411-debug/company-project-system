<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/svg+xml" href="{{ asset('public/image/favicon.png') }}">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="theme-color"
        content="#f5f5f7"
    >

    <title>WDC Construction— Project Directory</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/landing.css') }}"
    >

</head>

<body>

    <div class="landing-page">

        <!-- =====================================================
             NAVIGATION
             ===================================================== -->

        <nav class="navbar">

            <div class="nav-container">

                <a
                    href="{{ url('/') }}"
                    class="logo"
                    aria-label="WDC Project Directory"
                >

                    <span class="logo-mark">
                        W
                    </span>

                    <span class="logo-name">
                        WDC Construction
                    </span>

                </a>


                <div class="nav-links">

                    <a href="#overview">
                        Overview
                    </a>

                    <a href="#features">
                        Features
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="nav-signin"
                    >
                        Sign In
                    </a>

                </div>

            </div>

        </nav>


        <!-- =====================================================
             HERO
             ===================================================== -->

        <main>

            <section
                class="hero"
                id="overview"
            >

                <div class="hero-content">

                    <div class="hero-label">

                        <span class="label-dot"></span>

                        WDC Project Directory

                    </div>


                    <h1>

                        Your projects.
                        <br>

                        <span>
                            Simply organized.
                        </span>

                    </h1>


                    <p class="hero-text">

                        A focused workspace designed to help your
                        team manage projects, monitor progress,
                        and keep everything organized.

                    </p>


                    <div class="hero-button-wrapper">

                        <a
                            href="{{ route('login') }}"
                            class="hero-button"
                        >

                            <span>
                                Sign In
                            </span>

                            <span class="button-arrow">
                                →
                            </span>

                        </a>

                    </div>


                    <p class="secure-text">

                        Secure access for authorized users

                    </p>

                </div>


                <!-- Floating Product Element -->

                <div class="hero-object">

                    <div class="object-glow"></div>

                    <div class="object-card">

                        <div class="object-header">

                            <div class="object-brand">

                                <span class="mini-mark">
                                    W
                                </span>

                                <span>
                                    Project Directory
                                </span>

                            </div>

                            <div class="object-status">
                                ●
                            </div>

                        </div>


                        <div class="object-main">

                            <span class="object-small">
                                ACTIVE PROJECTS
                            </span>

                            <strong>
                                08
                            </strong>

                            <span class="object-caption">
                                Projects currently being managed
                            </span>

                        </div>


                        <div class="object-progress">

                            <div class="progress-label">

                                <span>
                                    Project progress
                                </span>

                                <span>
                                    72%
                                </span>

                            </div>

                            <div class="progress-track">

                                <div class="progress-value"></div>

                            </div>

                        </div>


                        <div class="object-footer">

                            <div>

                                <span class="footer-number">
                                    04
                                </span>

                                <span class="footer-label">
                                    Ongoing
                                </span>

                            </div>


                            <div>

                                <span class="footer-number">
                                    03
                                </span>

                                <span class="footer-label">
                                    Completed
                                </span>

                            </div>


                            <div>

                                <span class="footer-number">
                                    01
                                </span>

                                <span class="footer-label">
                                    Pending
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 INTRODUCTION
                 ================================================= -->

            <section class="statement">

                <div class="statement-inner">

                    <span class="section-label">
                        DESIGNED FOR FOCUS
                    </span>

                    <h2>

                        Everything important,
                        <span>
                            in one place.
                        </span>

                    </h2>

                    <p>

                        From project information to progress
                        tracking and reports, WDC Construction Project Directory
                        keeps your team's work structured and easy
                        to manage.

                    </p>

                </div>

            </section>


            <!-- =================================================
                 FEATURES
                 ================================================= -->

            <section
                class="features"
                id="features"
            >

                <div class="feature-grid">


                    <!-- Feature 01 -->

                    <article class="feature-card">

                        <div class="feature-number">
                            01
                        </div>

                        <div class="feature-icon">
                            ◇
                        </div>

                        <h3>
                            Projects
                        </h3>

                        <p>

                            Keep project details, status,
                            schedules, and important information
                            organized.

                        </p>

                    </article>


                    <!-- Feature 02 -->

                    <article class="feature-card">

                        <div class="feature-number">
                            02
                        </div>

                        <div class="feature-icon">
                            ◎
                        </div>

                        <h3>
                            People
                        </h3>

                        <p>

                            Manage authorized users and keep
                            access organized according to their
                            responsibilities.

                        </p>

                    </article>


                    <!-- Feature 03 -->

                    <article class="feature-card">

                        <div class="feature-number">
                            03
                        </div>

                        <div class="feature-icon">
                            ≋
                        </div>

                        <h3>
                            Reports
                        </h3>

                        <p>

                            Turn project information into clear
                            reports that help your team understand
                            progress.

                        </p>

                    </article>

                </div>

            </section>


            <!-- =================================================
                 CTA
                 ================================================= -->

            <section class="final-cta">

                <div class="cta-content">

                    <span class="section-label">
                        READY WHEN YOU ARE
                    </span>

                    <h2>

                        Start with
                        <span>
                            your projects.
                        </span>

                    </h2>

                    <p>

                        Sign in to access your Company Project
                        System.

                    </p>


                    <a
                        href="{{ route('login') }}"
                        class="cta-button"
                    >

                        Sign In

                        <span>
                            →
                        </span>

                    </a>

                </div>

            </section>

        </main>


        <!-- =====================================================
             FOOTER
             ===================================================== -->

        <footer class="footer">

            <div class="footer-inner">

                <div class="footer-brand">

                    <span class="footer-logo">
                        W
                    </span>

                    <span>
                        WDC Construction Project Directory
                    </span>

                </div>


                <div class="footer-copy">

                    © {{ date('Y') }} WDC Construction Project Directory

                </div>

            </div>

        </footer>

    </div>

</body>

</html>