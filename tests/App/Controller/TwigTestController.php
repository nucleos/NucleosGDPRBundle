<?php

declare(strict_types=1);

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class TwigTestController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('demo.html.twig');
    }
}
