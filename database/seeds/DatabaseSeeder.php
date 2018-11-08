<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected function getRules() : object
    {
        return collect([
            'SHOE_EU' => collect(range(20, 50))
                ->map(function($item, $index) {
                    return [
                        'value' => $item,
                        'index' => $index + 1,
                    ];
                })->all(),
                'SHOE_UK' => collect(range(1, 20, .5))
                    ->map(function($item) {
                        return $item . ' (Child)';
                    })
                    ->merge(range(1, 20, .5))
                    ->map(function($item, $index) {
                        return [
                            'value' => $item,
                            'index' => $index + 1,
                        ];
                    })
                    ->all(),
                'CLOTHING_SHORT' => collect(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL'])
                    ->map(function($item, $index) {
                        return [
                            'value' => $item,
                            'index' => $index + 1,
                        ];
                    })
                    ->all()
        ]);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->getRules()
            ->each(function($items, $index) {
                $rule = \App\Rule::firstOrCreate([ 'name' => $index ]);

                $rule
                    ->ruleEntities()
                    ->insert(
                        collect($items)
                            ->map(function($item) use ($rule) {
                                return [
                                    'value' => $item['value'],
                                    'index' => $item['index'],
                                    'rule_id' => $rule->id
                                ];
                            })
                            ->all()
                    );
            });
    }
}
