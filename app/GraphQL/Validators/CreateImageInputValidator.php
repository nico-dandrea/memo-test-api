<?php declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateImageInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "image_url"=> [
                // We use 'ends_with' because for some reasone extensions doesn't work properly
                "required", "ends_with:.jpg,.jpeg,.png", "unique:memo_test_images,image_url"
            ],
        ];
    }
}
