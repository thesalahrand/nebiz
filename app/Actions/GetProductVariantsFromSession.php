<?php
namespace App\Actions;

class GetProductVariantsFromSession
{
    private string $actionType;

    public const ACTION_CREATE = 'create';
    public const ACTION_EDIT = 'edit';

    public function setActionType($actionType): GetProductVariantsFromSession
    {
        $this->actionType = $actionType;
        return $this;
    }

    public function executeWhenCreate(): array
    {
        $variants = [
            [
                'name' => [
                    'value' => old('default_variant.name') ?? '',
                    'errors' => session('errors')?->get('default_variant.name') ?? []
                ],
                'brand_id' => [
                    'value' => old('default_variant.brand_id') ?? '',
                    'errors' => session('errors')?->get('default_variant.brand_id') ?? []
                ],
                'unit_name' => [
                    'value' => old('default_variant.unit_name') ?? '',
                    'errors' => session('errors')?->get('default_variant.unit_name') ?? []
                ],
                'price' => [
                    'value' => old('default_variant.price') ?? '',
                    'errors' => session('errors')?->get('default_variant.price') ?? []
                ],
                'quantity' => [
                    'value' => old('default_variant.quantity') ?? '',
                    'errors' => session('errors')?->get('default_variant.quantity') ?? []
                ],
                'image' => [
                    'value' => '',
                    'errors' => session('errors')?->get('default_variant.image') ?? []
                ],
                'additional_info' => [
                    'value' => old('default_variant.additional_info') ?? '',
                    'errors' => session('errors')?->get('default_variant.additional_info') ?? []
                ],
            ]
        ];

        $otherVariantsCnt = old('other_variants') ? count(old('other_variants')) : 0;
        for ($idx = 0; $idx < $otherVariantsCnt; $idx++) {
            $variants[] = [
                'price' => [
                    'value' => old("other_variants.$idx.price") ?? '',
                    'errors' => session('errors')?->get("other_variants.$idx.price") ?? []
                ],
                'quantity' => [
                    'value' => old("other_variants.$idx.quantity") ?? '',
                    'errors' => session('errors')?->get("other_variants.$idx.quantity") ?? []
                ],
                'image' => [
                    'value' => '',
                    'errors' => session('errors')?->get("other_variants.$idx.image") ?? []
                ],
            ];
        }

        return $variants;
    }

    public function executeWhenEdit(): array
    {
        return [];
    }

    public function execute(): array
    {
        return $this->actionType === self::ACTION_CREATE ? $this->executeWhenCreate() : $this->executeWhenEdit();
    }
}
?>