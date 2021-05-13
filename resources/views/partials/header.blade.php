<header>
    <div id="header">
        <div id="header-logo-container">
            <a href="">
                <img src="assets/images/logos/large-logo.png" alt="header logo" id="header-logo">
            </a>
        </div>
        <div class="h-menu">
            <a href="" class="menu-link-button">Home</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Annoucemenets</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">About Us</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Contact</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">FAQ</a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="" method="POST" class="search-forum">
                    <input type="text" name="search-field" autocomplete="off" class="search-field" placeholder="Search ..">
                    <input type="submit" value="search" class="search-button" style="margin-left: -10px">
                </form>
            </div>
            @auth

            @endauth

            @guest
            <div id="login">
                <a href="" id="login-signin-button" class="white fs14 background-partial">Register / Login</a>
            </div>
            @endguest
        </div>
    </div>
    <div id="second-header">
        <div id="forum-header" class="flex">
            <div class="h-menu">
                <div class="relative">
                    <a href="" class="menu-link-button wmenu-icon button-with-suboptions background-partial">Quick links</a>
                    <div class="suboptions-container suboptions-buttons-style">
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>        
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                    </div>
                </div>
                <div class="menu-separator">〡</div>
                <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button question-icon background-partial">Questions</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button fire-icon background-partial">Active Topics</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button article-icon background-partial">Articles</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button settings-icon background-partial">Adv. Search</a>
            </div>

            <div class="move-to-right flex align-center">
                <a href="" class="menu-link-button feather-icon background-partial">Become a writer</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button edit-icon background-partial">Write a question</a>
            </div>
        </div>
    </div>
</header>