<?php

namespace App\Http\Transformers;

interface TransformerInterface
{
    public function transform(array $data): array;
}
