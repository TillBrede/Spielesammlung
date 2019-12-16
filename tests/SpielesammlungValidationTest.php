<?php

declare(strict_types=1);
include_once __DIR__ . '/stubs/Validator.php';
class SpielesammlungValidationTest extends TestCaseSymconValidation
{
    public function testValidateSpielesammlung(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }
    public function testValidateSchereSteinPapierModule(): void
    {
        $this->validateModule(__DIR__ . '/../SchereSteinPapier');
    }
    public function testValidateZahlenratenModule(): void
    {
        $this->validateModule(__DIR__ . '/../Zahlenraten');
    }
}