<?php declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateMemoTestInput extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "name" => [
                "required", "string", "unique:memo_tests,name"
            ]
        ];
    }
}
