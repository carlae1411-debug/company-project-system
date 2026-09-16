document.addEventListener("DOMContentLoaded", function () {

    /*
    ========================================
    ELEMENTS
    ========================================
    */

    const sidebar =
        document.getElementById("sidebar");

    const menuToggle =
        document.getElementById("menuToggle");

    const sidebarOverlay =
        document.getElementById("sidebarOverlay");

    const pageContent =
        document.getElementById("pageContent");


    /*
    ========================================
    SIDEBAR
    ========================================
    */

    function openSidebar() {

        if (!sidebar) return;

        sidebar.classList.add("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.add("show");
        }

        document.body.style.overflow = "hidden";
    }


    function closeSidebar() {

        if (!sidebar) return;

        sidebar.classList.remove("open");

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove("show");
        }

        document.body.style.overflow = "";
    }


    if (menuToggle) {

        menuToggle.addEventListener("click", function () {

            if (sidebar.classList.contains("open")) {

                closeSidebar();

            } else {

                openSidebar();

            }

        });

    }


    /*
    ========================================
    SIDEBAR OVERLAY
    ========================================
    */

    if (sidebarOverlay) {

        sidebarOverlay.addEventListener("click", function () {

            closeSidebar();

        });

    }


    /*
    ========================================
    CLOSE SIDEBAR ON ESC
    ========================================
    */

    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            closeSidebar();

        }

    });


    /*
    ========================================
    PAGE TRANSITION
    ========================================
    */

    const navigationItems =
        document.querySelectorAll(".nav-item");


    navigationItems.forEach(function (item) {

        item.addEventListener("click", function (event) {

            const targetUrl =
                item.getAttribute("href");


            /*
            Ignore buttons / empty links
            */

            if (
                !targetUrl ||
                targetUrl === "#" ||
                targetUrl.startsWith("#") ||
                targetUrl.startsWith("javascript:")
            ) {
                return;
            }


            /*
            Ignore external links
            */

            if (
                targetUrl.startsWith("http") &&
                !targetUrl.includes(window.location.host)
            ) {
                return;
            }


            /*
            Don't animate if already
            on the same page.
            */

            if (
                targetUrl === window.location.href ||
                targetUrl === window.location.pathname
            ) {
                return;
            }


            /*
            Prevent the normal navigation
            temporarily.
            */

            event.preventDefault();


            /*
            Close mobile sidebar.
            */

            if (window.innerWidth <= 700) {

                closeSidebar();

            }


            /*
            Slide page out.
            */

            if (pageContent) {

                pageContent.classList.add(
                    "page-slide-out"
                );

            }


            /*
            Navigate after animation.
            */

            setTimeout(function () {

                window.location.href =
                    targetUrl;

            }, 220);

        });

    });


    /*
    ========================================
    PAGE LOAD
    ========================================
    */

    if (pageContent) {

        pageContent.classList.add(
            "page-slide-in"
        );

    }


    /*
    ========================================
    WINDOW RESIZE
    ========================================
    */

    window.addEventListener("resize", function () {

        if (window.innerWidth > 700) {

            closeSidebar();

        }

    });

});

function confirmRestoreProject() {

    const projectName = document.querySelector(
        '.archived-detail-title h2'
    );

    const name = projectName
        ? projectName.textContent.trim()
        : 'this project';

    return confirm(
        `Restore "${name}"?\n\n` +
        `This project will be returned to the active Projects list.`
    );
}

function confirmPermanentDeleteProject() {
    const projectName = document.querySelector(
        '.archived-detail-title h2'
    );

    const name = projectName
        ? projectName.textContent.trim()
        : 'this project';

    return confirm(
        `Permanently delete "${name}"?\n\n` +
        `WARNING: This action cannot be undone.\n` +
        `The archived project will be permanently removed.`
    );
}

/* =========================================================
   USER MENU DROPDOWN
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const userMenu = document.getElementById('userMenu');
    const userMenuTrigger = document.getElementById('userMenuTrigger');

    if (!userMenu || !userMenuTrigger) {
        return;
    }

    userMenuTrigger.addEventListener('click', function (event) {

        event.stopPropagation();

        const isOpen = userMenu.classList.toggle('open');

        userMenuTrigger.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Close when clicking outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (!userMenu.contains(event.target)) {

            userMenu.classList.remove('open');

            userMenuTrigger.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Close with Escape key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            userMenu.classList.remove('open');

            userMenuTrigger.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

});

