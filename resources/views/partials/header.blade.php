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
            <a href="" class="menu-link-button">Today's posts</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Active Topics</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Adv. Search</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">FAQ</a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="" method="POST" class="search-forum">
                    <input type="text" name="search-field" autocomplete="off" class="search-field" placeholder="Search ..">
                    <input type="submit" value="search" class="search-button" style="margin-left: -5px">
                </form>
            </div>
            @auth

            @endauth

            @guest
            <div id="login">
                <a href="" id="login-signin-button" class="white fs14">Register / Login</a>
            </div>
            @endguest
        </div>
    </div>
    <div id="second-header">
        <div id="forum-header" class="flex">
            <div class="h-menu">
                <div class="relative">
                    <a href="" class="menu-link-button vmenu-icon button-with-suboptions">Quick links</a>
                    <div class="suboptions-container">
                        <h2 style="margin: 0; padding: 6px">This is suboption header</h2>
                    </div>
                </div>
                <div class="menu-separator2">〡</div>
                <a href="" class="menu-link-button">Articles</a>
                <div class="menu-separator2">〡</div>
                <a href="" class="menu-link-button">Advices</a>
                <div class="menu-separator2">〡</div>
                <a href="" class="menu-link-button">Rooms</a>
            </div>

            <div class="move-to-right flex align-center">
                <a href="" class="menu-link-button">Become a writer</a>
                <div class="menu-separator2">〡</div>
                <a href="" class="menu-link-button edit-icon">Write a question</a>
            </div>
        </div>
    </div>
</header>