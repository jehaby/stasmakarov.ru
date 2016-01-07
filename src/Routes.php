<?php

return [
    ['GET', '/', ['Jehaby\Homepage\Controllers\Main', 'index']],
    ['GET', '/{slug}', ['Jehaby\Homepage\Controllers\Page', 'show']],
    //    ['POST', '/login', ['Timely\Controllers\Auth', 'index']],
];
