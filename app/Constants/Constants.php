<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: SillyCat
 * Date: 2025-06-18
 * Time: 21:49
 */

namespace App\Constants;
use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants as AnnotationConstants;

#[AnnotationConstants]
class Constants extends AbstractConstants
{
    public const AUTHORIZATION = 'Authorization';
}