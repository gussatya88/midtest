<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item  ">
                <a href="/" class='menu-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-item active has-sub">
                <a href="#" class='menu-link'>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Master Data</span>
                </a>
                <div class="submenu ">
                    <ul class="submenu-group">

                        <li class="submenu-item ">
                            <a href="{{ route('category.index') }}" class='submenu-link'>Category</a>
                        </li>

                        <li class="submenu-item  ">
                            <a href="{{ route('product.index') }}" class='submenu-link'>Product</a>
                        </li>

                        <li class="submenu-item  ">
                            <a href="{{ route('package.index') }}" class='submenu-link'>Package</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
