<?php
function active(string $url)
{
    $current_route = $_SERVER['REQUEST_URI'];

    return substr($current_route, 0, strlen($url)) === $url ? 'active' : '';
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">MyApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= active('/home') ?>" href="/home">Home <span class="visually-hidden">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active('/create') ?>" href="/create">Create</a>
                </li>
            </ul>
        </div>
    </div>
</nav>