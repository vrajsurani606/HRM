<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialReport;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Fine Aggregate
        $fineAggregate = Material::create([
            'name' => 'Fine Aggregate',
            'order' => 1,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Alkali Aggregate', 'order' => 1]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'reactivity: Reduction of alkalinity', 'order' => 2]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Light weight Pieces (Coal and lignite)', 'order' => 3]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Organic impurity', 'order' => 4]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'PH', 'order' => 5]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'AT', 'order' => 6]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Soundness with Na2SO4', 'order' => 7]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Sulphate', 'order' => 8]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Chloride', 'order' => 9]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'PH', 'order' => 10]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Sulphate', 'order' => 11]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Carbon', 'order' => 12]);
        MaterialReport::create(['material_id' => $fineAggregate->id, 'name' => 'Manganese', 'order' => 13]);

        // Coarse Aggregate
        $coarseAggregate = Material::create([
            'name' => 'Coarse Aggregate',
            'order' => 2,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Alkali Aggregate reactivity', 'order' => 1]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Soundness with Na2SO4', 'order' => 2]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Flakiness Index', 'order' => 3]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Elongation Index', 'order' => 4]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Impact Value', 'order' => 5]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Abrasion Value', 'order' => 6]);
        MaterialReport::create(['material_id' => $coarseAggregate->id, 'name' => 'Crushing Value', 'order' => 7]);

        // Concrete
        $concrete = Material::create([
            'name' => 'Concrete',
            'order' => 3,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $concrete->id, 'name' => 'Compressive Strength (7 Days)', 'order' => 1]);
        MaterialReport::create(['material_id' => $concrete->id, 'name' => 'Compressive Strength (28 Days)', 'order' => 2]);
        MaterialReport::create(['material_id' => $concrete->id, 'name' => 'Slump Test', 'order' => 3]);
        MaterialReport::create(['material_id' => $concrete->id, 'name' => 'Chloride Content', 'order' => 4]);
        MaterialReport::create(['material_id' => $concrete->id, 'name' => 'Sulphate Content', 'order' => 5]);

        // Water
        $water = Material::create([
            'name' => 'Water',
            'order' => 4,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $water->id, 'name' => 'PH Value', 'order' => 1]);
        MaterialReport::create(['material_id' => $water->id, 'name' => 'Chloride Content', 'order' => 2]);
        MaterialReport::create(['material_id' => $water->id, 'name' => 'Sulphate Content', 'order' => 3]);
        MaterialReport::create(['material_id' => $water->id, 'name' => 'Total Dissolved Solids', 'order' => 4]);
        MaterialReport::create(['material_id' => $water->id, 'name' => 'Suspended Solids', 'order' => 5]);

        // Cement
        $cement = Material::create([
            'name' => 'Cement',
            'order' => 5,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Fineness', 'order' => 1]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Normal Consistency', 'order' => 2]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Initial Setting Time', 'order' => 3]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Final Setting Time', 'order' => 4]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Compressive Strength (3 Days)', 'order' => 5]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Compressive Strength (7 Days)', 'order' => 6]);
        MaterialReport::create(['material_id' => $cement->id, 'name' => 'Compressive Strength (28 Days)', 'order' => 7]);

        // Steel
        $steel = Material::create([
            'name' => 'Steel',
            'order' => 6,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Tensile Strength', 'order' => 1]);
        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Yield Strength', 'order' => 2]);
        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Elongation', 'order' => 3]);
        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Bend Test', 'order' => 4]);
        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Rebend Test', 'order' => 5]);
        MaterialReport::create(['material_id' => $steel->id, 'name' => 'Chemical Composition', 'order' => 6]);

        // Brick
        $brick = Material::create([
            'name' => 'Brick',
            'order' => 7,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $brick->id, 'name' => 'Compressive Strength', 'order' => 1]);
        MaterialReport::create(['material_id' => $brick->id, 'name' => 'Water Absorption', 'order' => 2]);
        MaterialReport::create(['material_id' => $brick->id, 'name' => 'Efflorescence', 'order' => 3]);
        MaterialReport::create(['material_id' => $brick->id, 'name' => 'Dimension Tolerance', 'order' => 4]);

        // Soil
        $soil = Material::create([
            'name' => 'Soil',
            'order' => 8,
            'is_active' => true,
        ]);

        MaterialReport::create(['material_id' => $soil->id, 'name' => 'Liquid Limit', 'order' => 1]);
        MaterialReport::create(['material_id' => $soil->id, 'name' => 'Plastic Limit', 'order' => 2]);
        MaterialReport::create(['material_id' => $soil->id, 'name' => 'Plasticity Index', 'order' => 3]);
        MaterialReport::create(['material_id' => $soil->id, 'name' => 'Compaction Test', 'order' => 4]);
        MaterialReport::create(['material_id' => $soil->id, 'name' => 'California Bearing Ratio (CBR)', 'order' => 5]);
        MaterialReport::create(['material_id' => $soil->id, 'name' => 'Grain Size Distribution', 'order' => 6]);
    }
}
