<?php
// Debug script to check quotation templates and proformas
// Place this in your public folder and access via browser

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Quotation;
use App\Models\Proforma;

$quotationId = $_GET['id'] ?? 2; // Default to quotation ID 2

echo "<h2>Debug: Quotation Templates and Proformas</h2>";
echo "<p>Quotation ID: {$quotationId}</p>";

$quotation = Quotation::with('proformas')->find($quotationId);

if (!$quotation) {
    echo "<p style='color: red;'>Quotation not found!</p>";
    exit;
}

echo "<h3>Quotation Details:</h3>";
echo "<p><strong>Company:</strong> {$quotation->company_name}</p>";
echo "<p><strong>Code:</strong> {$quotation->unique_code}</p>";

echo "<h3>Payment Terms (Templates):</h3>";
if ($quotation->terms_description && is_array($quotation->terms_description)) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Index</th><th>Description</th><th>Completion %</th><th>Completion Terms</th><th>Amount</th></tr>";
    
    foreach ($quotation->terms_description as $index => $description) {
        if (!empty($description)) {
            $completionPercent = $quotation->terms_completion[$index] ?? 0;
            $completionTerms = $quotation->completion_terms[$index] ?? '';
            $amount = $quotation->terms_total[$index] ?? 0;
            
            echo "<tr>";
            echo "<td>{$index}</td>";
            echo "<td>{$description}</td>";
            echo "<td>{$completionPercent}%</td>";
            echo "<td>{$completionTerms}</td>";
            echo "<td>₹" . number_format($amount, 2) . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p>No payment terms found.</p>";
}

echo "<h3>Generated Proformas:</h3>";
if ($quotation->proformas->count() > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Code</th><th>Template Index</th><th>Type of Billing</th><th>Amount</th><th>Date</th></tr>";
    
    foreach ($quotation->proformas as $proforma) {
        echo "<tr>";
        echo "<td>{$proforma->id}</td>";
        echo "<td>{$proforma->unique_code}</td>";
        echo "<td>" . ($proforma->template_index ?? 'NULL') . "</td>";
        echo "<td>{$proforma->type_of_billing}</td>";
        echo "<td>₹" . number_format($proforma->final_amount, 2) . "</td>";
        echo "<td>{$proforma->proforma_date->format('d-m-Y')}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No proformas generated yet.</p>";
}

echo "<h3>Template Status Check:</h3>";
if ($quotation->terms_description && is_array($quotation->terms_description)) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Template Index</th><th>Description</th><th>Proforma Exists?</th><th>Proforma Code</th></tr>";
    
    foreach ($quotation->terms_description as $index => $description) {
        if (!empty($description)) {
            $proformaGenerated = $quotation->proformas->where('template_index', $index)->first();
            
            echo "<tr>";
            echo "<td>{$index}</td>";
            echo "<td>{$description}</td>";
            echo "<td>" . ($proformaGenerated ? 'YES' : 'NO') . "</td>";
            echo "<td>" . ($proformaGenerated ? $proformaGenerated->unique_code : '-') . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}

echo "<p><a href='?id=" . ($quotationId + 1) . "'>Next Quotation</a> | <a href='?id=" . ($quotationId - 1) . "'>Previous Quotation</a></p>";
?>