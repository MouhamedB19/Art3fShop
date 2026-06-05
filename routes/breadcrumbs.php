<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Accueil', route('home'));
});

Breadcrumbs::for('catalogue', function (BreadcrumbTrail $trail, $categorie) {
    $trail->parent('home');
    $trail->push($categorie, route('catalogue.categorie', $categorie));
});
// Accueil > Blog
Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog.index'));
});