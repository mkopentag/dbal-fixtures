<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\Fixtures\Processors;

use ComPHPPuebla\Fixtures\Database\Row;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements PreProcessor
{
    public function beforeInsert(Row $row): void
    {
        foreach ($row->values() as $column => $value) {
            if ('${uuid}' === $value) {
                $row->changeColumnValue($column, Uuid::uuid4()->toString());
            }
        }
    }
}
