<?php

namespace SBD\Softbd\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SBD\Softbd\Database\Types\Type;

class BinaryType extends Type
{
    const NAME = 'binary';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        $field['length'] = empty($field['length']) ? 255 : $field['length'];

        return "binary({$field['length']})";
    }
}
