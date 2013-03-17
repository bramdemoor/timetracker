<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="/timetracker/index.php?entries">Timetracker</a>
        <ul class="nav">
            <?php $currentPage = basename($_SERVER['REQUEST_URI']); ?>
            <li <?php if($currentPage == "index.php?entries") echo ' class="active"'; ?>><a href="/timetracker/index.php?entries">Entries</a></li>
            <li <?php if($currentPage == "index.php?reports") echo ' class="active"'; ?>><a href="/timetracker/index.php?reports">Reporting</a></li>
            <li <?php if($currentPage == "index.php?export") echo ' class="active"'; ?>><a href="/timetracker/index.php?export">Export</a></li>
        </ul>
    </div>
</div>