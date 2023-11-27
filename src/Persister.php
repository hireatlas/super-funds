<?php

namespace Atlas\LaravelAustralianSuperannuationFunds;

use Atlas\LaravelAustralianSuperannuationFunds\Contracts\Persister as PersisterContract;
use Atlas\LaravelAustralianSuperannuationFunds\DTOs\SuperannuationFundDTO;
use Atlas\LaravelAustralianSuperannuationFunds\Exceptions\PersistException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Persister implements PersisterContract
{
    public function __construct(
        private string $modelClass
    ) {
        //
    }

    public function persist(Collection $collection): Collection
    {
        /** @var Model $modelInstance */
        $modelInstance = new $this->modelClass();

        try {
            $modelInstance
                ->getConnection()
                ->transaction(function () use ($collection, $modelInstance) {
                    $this->upsertAllNewModels($collection, $modelInstance);

                    $this->updateValidFieldForAllModels($modelInstance);
                });
        } catch (\Throwable|\Exception $exception) {
            throw new PersistException(previous: $exception);
        }

        return $collection;
    }

    private function upsertAllNewModels(Collection $collection, Model $modelInstance): void
    {
        $modelInstance::query()
            ->upsert(
                $collection
                    ->map(function (SuperannuationFundDTO $dto) {
                        return [
                            'usi' => $dto->usi,
                            'abn' => $dto->abn,
                            'fund_name' => $dto->fundName,
                            'product_name' => $dto->productName,
                            'restricts_contributions' => $dto->restrictsContributions,
                            'valid' => $dto->valid,
                            'valid_from' => $dto->validFrom->format('Y-m-d'),
                            'valid_to' => $dto->validTo?->format('Y-m-d'),
                        ];
                    })
                    ->all(),
                [
                    'usi',
                ],
                [
                    'abn',
                    'fund_name',
                    'product_name',
                    'restricts_contributions',
                    'valid',
                    'valid_from',
                    'valid_to',
                ]
            );
    }

    private function updateValidFieldForAllModels(Model $modelInstance): void
    {
        $modelInstance::query()
            ->where('valid', '=', true)
            ->where(function ($query) {
                $now = now('Australia/Sydney')->format('Y-m-d');

                return $query
                    ->where('valid_from', '>', $now)
                    ->orWhere('valid_to', '<=', $now);
            })
            ->update([
                'valid' => false,
            ]);
    }
}
