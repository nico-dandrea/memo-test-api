<?php declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class UpdateImageInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "id"       => [
                "required", "exists:memo_test_images,id"
            ],
            "image_url"=> [
                // We use 'ends_with' because for some reasone extensions doesn't work properly
                "required", "ends_with:.jpg,.jpeg,.png", "unique:memo_test_images,image_url"
            ],
        ];
    }
}
