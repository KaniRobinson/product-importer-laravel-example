<?php

namespace App\Http\Controllers;

use App\Rule;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Rules from Database
        $rules = Rule::with('ruleEntities')->get();

        // Import Products and group by Field
        $importer = (new \ProductImporter\Csv(storage_path('app/csv/products.csv')))
            ->groupBy('PLU');

        // Add Rules
        $rules->each(function($rule) use ($importer) {
            $importer->addRule($rule->name, 'size', $rule->ruleEntities->map(function($entity) {
                return $entity->value;
            })->all());
        });

        // Sort and remap the Data
        $importer
            ->sortByRule('sizeSort')
            ->mapToStructure([
                'PLU',
                'name',
                'sizes' => [
                    'SKU',
                    'size'
                ]
            ]);

        // Return Data back to the view
        return view('main', [
            'rules' => $rules,
            'data' => $importer->get()
        ]);
    }

    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        // Get Rules from Database
        $rules = Rule::with('ruleEntities')->get();

        // Import Products and group by Field
        $importer = (new \ProductImporter\Csv(storage_path('app/csv/products.csv')))
            ->groupBy('PLU');

        // Add Rules
        $rules->each(function($rule) use ($importer) {
            $importer->addRule($rule->name, 'size', $rule->ruleEntities->map(function($entity) {
                return $entity->value;
            })->all());
        });

        // Sort and remap the Data
        $importer
            ->sortByRule('sizeSort')
            ->mapToStructure([
                'PLU',
                'name',
                'sizes' => [
                    'SKU',
                    'size'
                ]
            ]);

        return ProductResource::collection(collect($importer->get('plain')))
            ->response();
    }
}
