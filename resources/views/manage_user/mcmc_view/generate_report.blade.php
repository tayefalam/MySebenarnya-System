<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(isset($title))
            {{ $title }}
        @else
            Reports
        @endif
    </title>
    
    @if(!isset($is_pdf) || !$is_pdf)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @endif

    <style>
        @if(isset($is_pdf) && $is_pdf)
        /* PDF Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0e630e;
            padding-bottom: 15px;
        }

        .report-header h1 {
            color: #0e630e;
            margin: 0;
            font-size: 20px;
        }

        .report-info {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th {
            background: #0e630e;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        .report-table td {
            padding: 6px;
            border-bottom: 1px solid #dee2e6;
            font-size: 10px;
            word-wrap: break-word;
        }

        .report-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #ffc107;
            font-weight: bold;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .stats-table th {
            background: #0e630e;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        .stats-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .stats-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .section-title {
            color: #0e630e;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #0e630e;
            padding-bottom: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            width: 40%;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .reports-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 1400px;
            overflow: hidden;
        }

        .reports-header {
            background: linear-gradient(135deg, #0e630e, #145a14);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .reports-header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
        }

        .reports-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        /* Statistics Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            border-color: #0e630e;
        }

        .stat-card i {
            font-size: 2.5em;
            color: #0e630e;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Report Tabs */
        .report-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .tab-button {
            flex: 1;
            background: none;
            border: none;
            padding: 20px;
            font-size: 16px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .tab-button:hover {
            background: #e9ecef;
            color: #0e630e;
        }

        .tab-button.active {
            background: #0e630e;
            color: white;
            border-bottom: 3px solid #0a4d0a;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 30px;
        }

        .tab-content.active {
            display: block;
        }

        /* Report Cards */
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-top: 20px;
            justify-content: center;
        }

        .report-card {
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-color: #0e630e;
        }

        .report-card h3 {
            color: #0e630e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #0e630e;
            color: white;
        }

        .btn-primary:hover {
            background: #0a4d0a;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            color: #0e630e;
            text-decoration: none;
            padding: 12px 20px;
            border: 2px solid #0e630e;
            border-radius: 8px;
            margin: 20px 30px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #0e630e;
            color: white;
        }



        /* Report Display Mode */
        .report-display-mode {
            padding: 30px;
        }

        .action-buttons {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 2px solid #dee2e6;
        }

        .action-buttons .btn-group {
            margin-top: 0;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            border-radius: 10px;
            border: 2px solid #dee2e6;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .report-table th {
            background: #0e630e;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #0a4d0a;
        }

        .report-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: top;
        }

        .report-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .report-table tr:hover {
            background: #e8f5e8;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px solid #dee2e6;
        }

        .empty-state i {
            font-size: 4em;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #495057;
            margin-bottom: 10px;
        }

        /* System Report Specific Styles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .system-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #dee2e6;
            margin-bottom: 20px;
        }

        .system-info h3 {
            color: #0e630e;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        /* Custom Report Styles */
        .field-options {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            background: #f8f9fa;
        }

        .field-options .form-check {
            margin-bottom: 8px;
        }

        .field-options .form-check-label {
            font-size: 0.9em;
            margin-left: 5px;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .form-label i {
            color: #0e630e;
            margin-right: 5px;
        }

        .btn-lg {
            padding: 12px 30px;
            font-size: 16px;
        }

        /* Print Styles */
        @media print {
            .report-tabs, .btn-group, .search-box, .back-btn, .action-buttons {
                display: none !important;
            }
            
            body {
                background: white !important;
                padding: 0;
            }
            
            .reports-container {
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0;
            }
            
            .reports-header {
                background: #0e630e !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .report-table th {
                background: #0e630e !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .report-tabs {
                flex-direction: column;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .stat-card {
                padding: 20px;
            }
        }
        @else
        /* Web Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            color: #0e630e;
            text-decoration: none;
            padding: 12px 20px;
            border: 2px solid #0e630e;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-btn:hover {
            background: #0e630e;
            color: white;
        }

        .back-btn i {
            margin-right: 8px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Report Content Container */
        .report-content {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        /* Action Buttons */
        .action-buttons {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: #0e630e;
            color: white;
        }

        .btn-primary:hover {
            background: #0a4e0a;
            transform: translateY(-1px);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-1px);
        }

        /* Report Table */
        .report-table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .table-header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 20px;
        }

        .table-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .report-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }

        .report-table tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .bg-success {
            background: #d4edda;
            color: #155724;
        }

        .bg-warning {
            background: #fff3cd;
            color: #856404;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .stat-card i {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .stat-total {
            color: #0e630e;
        }

        .stat-agencies {
            color: #007bff;
        }

        .stat-active {
            color: #28a745;
        }

        .stat-recent {
            color: #ffc107;
        }

        /* System Info */
        .system-info {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .system-info h3 {
            margin: 0 0 20px 0;
            color: #0e630e;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .empty-state i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #ccc;
        }

        /* Report Navigation */
        .report-navigation {
            margin: 30px 0;
        }

        .nav-tabs {
            display: flex;
            gap: 5px;
            background: white;
            border-radius: 10px;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        .nav-tab {
            flex: 1;
            padding: 15px 20px;
            background: transparent;
            border: none;
            border-radius: 8px;
            color: #666;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 120px;
        }

        .nav-tab i {
            font-size: 20px;
        }

        .nav-tab span {
            font-size: 14px;
        }

        .nav-tab.active,
        .nav-tab:hover {
            background: #0e630e;
            color: white;
        }

        /* Tab Content */
        .tab-content-container {
            min-height: 500px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Report Sections */
        .report-section {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-header {
            background: linear-gradient(135deg, #0e630e, #28a745);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .section-header h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        .section-header p {
            margin: 0;
            opacity: 0.9;
        }

        /* Report Options */
        .report-options {
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .option-card {
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .option-card:hover {
            border-color: #0e630e;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-icon {
            background: #0e630e;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card-icon i {
            font-size: 30px;
        }

        .card-content {
            padding: 20px;
        }

        .card-content h3 {
            margin: 0 0 10px 0;
            color: #0e630e;
            font-size: 18px;
        }

        .card-content p {
            margin: 0 0 20px 0;
            color: #666;
            line-height: 1.5;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Custom Form Enhancements */
        .custom-form {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-container {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e9ecef;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section h3 {
            margin: 0 0 20px 0;
            color: #0e630e;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-item:hover {
            border-color: #0e630e;
            background: #e8f5e8;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
        }

        .radio-item input[type="radio"]:checked + label {
            color: #0e630e;
            font-weight: 600;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .custom-form {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .form-header h3 {
            margin: 0;
            color: #0e630e;
            font-size: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #0e630e;
            box-shadow: 0 0 0 3px rgba(14, 99, 14, 0.1);
        }

        .checkboxes-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
            }
            
            .back-btn,
            .action-buttons {
                display: none !important;
            }
            
            .report-table-container {
                box-shadow: none !important;
                border: 1px solid #ddd;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .report-tabs {
                flex-direction: column;
            }
        }
        @endif
    </style>
</head>
<body>
    @if(isset($is_pdf) && $is_pdf)
        {{-- PDF Layout --}}
        <div class="report-header">
            <h1>{{ $title ?? 'MCMC Report' }}</h1>
        </div>

        <div class="report-info">
            <strong>Generated:</strong> {{ now()->format('d/m/Y H:i:s') }}<br>
            @if(isset($users))
                <strong>Total Records:</strong> {{ count($users) }}
            @elseif(isset($agencies))
                <strong>Total Records:</strong> {{ count($agencies) }}
            @endif
        </div>

        {{-- Users Report PDF --}}
        @if(isset($users))
            @if(count($users) > 0)
                <table class="report-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 15%;">Name</th>
                            <th style="width: 15%;">Email</th>
                            <th style="width: 10%;">Phone</th>
                            <th style="width: 12%;">IC Number</th>
                            <th style="width: 20%;">Address</th>
                            <th style="width: 10%;">Agency</th>
                            <th style="width: 8%;">Status</th>
                            <th style="width: 15%;">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user['id'] ?? 'N/A' }}</td>
                                <td>{{ $user['name'] ?? 'N/A' }}</td>
                                <td>{{ $user['email'] ?? 'N/A' }}</td>
                                <td>{{ $user['phone'] ?? 'N/A' }}</td>
                                <td>{{ $user['ic_number'] ?? 'N/A' }}</td>
                                <td>{{ $user['address'] ?? 'N/A' }}</td>
                                <td>{{ $user['agency'] ?? 'Public' }}</td>
                                <td class="{{ isset($user['status']) && $user['status'] === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ isset($user['status']) ? ucfirst($user['status']) : 'N/A' }}
                                </td>
                                <td>{{ isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 5px;">
                    <h3>No Data Available</h3>
                    <p>No users found matching the selected criteria.</p>
                </div>
            @endif
        @endif

        {{-- Agencies Report PDF --}}
        @if(isset($agencies))
            @if(count($agencies) > 0)
                <table class="report-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Agency Name</th>
                            <th style="width: 12%;">Type</th>
                            <th style="width: 15%;">Contact Person</th>
                            <th style="width: 15%;">Email</th>
                            <th style="width: 10%;">Phone</th>
                            <th style="width: 15%;">Address</th>
                            <th style="width: 8%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agencies as $agency)
                            <tr>
                                <td>{{ $agency['id'] ?? 'N/A' }}</td>
                                <td>{{ $agency['agency_name'] ?? 'N/A' }}</td>
                                <td>{{ $agency['agency_type'] ?? 'N/A' }}</td>
                                <td>{{ $agency['contact_person'] ?? 'N/A' }}</td>
                                <td>{{ $agency['email'] ?? 'N/A' }}</td>
                                <td>{{ $agency['phone'] ?? 'N/A' }}</td>
                                <td>{{ $agency['address'] ?? 'N/A' }}</td>
                                <td class="{{ isset($agency['status']) && $agency['status'] === 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ isset($agency['status']) ? ucfirst($agency['status']) : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 5px;">
                    <h3>No Data Available</h3>
                    <p>No agencies found matching the selected criteria.</p>
                </div>
            @endif
        @endif

        {{-- System Report PDF --}}
        @if(isset($system_data))
            <!-- System Statistics -->
            <div class="section-title">System Statistics</div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Users</td>
                        <td>{{ $system_data['total_users'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Total Agencies</td>
                        <td>{{ $system_data['total_agencies'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Active Users</td>
                        <td>{{ $system_data['active_users'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Recent Registrations (30 days)</td>
                        <td>{{ $system_data['recent_registrations'] ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- System Information -->
            <div class="section-title">System Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">System Version:</div>
                    <div class="info-value">{{ $system_data['system_version'] ?? 'v1.0.0' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">PHP Version:</div>
                    <div class="info-value">{{ $system_data['php_version'] ?? phpversion() }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Laravel Version:</div>
                    <div class="info-value">{{ $system_data['laravel_version'] ?? app()->version() }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Database Type:</div>
                    <div class="info-value">{{ $system_data['database_type'] ?? 'MySQL' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Server:</div>
                    <div class="info-value">{{ $system_data['server_info'] ?? $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</div>
                </div>
            </div>

            <!-- Database Statistics -->
            @if(isset($system_data['database_stats']))
            <div class="section-title">Database Statistics</div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Table</th>
                        <th>Records</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($system_data['database_stats'] as $table => $count)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $table)) }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        @endif

        <div class="footer">
            <p>MCMC Reports System - Generated on {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

    @else
        {{-- HTML/Web Layout --}}
        <div class="container">
            {{-- Back Button --}}
            @if(isset($title))
                <a href="{{ route('mcmc.reports') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Reports Dashboard
                </a>
            @else
                <a href="{{ route('mcmc.dashboard') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            @endif

            {{-- Header --}}
            <div class="header">
                <h1>
                    <i class="fas fa-chart-bar"></i>
                    @if(isset($title))
                        {{ $title }}
                    @else
                        MCMC Reports Dashboard
                    @endif
                </h1>
                @if(!isset($title))
                    <p>Generate comprehensive reports for users, agencies, and system analytics</p>
                @endif
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            {{-- Individual Report Display --}}
            @if(isset($title) && (isset($users) || isset($agencies) || isset($system_data)))
                <div class="action-buttons">
                    <div class="btn-group">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                        
                        <button onclick="window.location.reload()" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> Refresh Data
                        </button>
                        
                        @if(isset($report_type))
                            <button onclick="goBackToCustom()" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modify Report
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Users Report --}}
                @if(isset($users))
                    @if(count($users) > 0)
                        <div class="report-table-container">
                            <div class="table-header">
                                <h3><i class="fas fa-users"></i> Users Report</h3>
                            </div>
                            <div class="table-container">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            @if(isset($selected_fields))
                                                @foreach($selected_fields as $field)
                                                    <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                                                @endforeach
                                            @else
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>IC Number</th>
                                                <th>Address</th>
                                                <th>Agency</th>
                                                <th>Status</th>
                                                <th>Registered Date</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                @if(isset($selected_fields))
                                                    @foreach($selected_fields as $field)
                                                        <td>
                                                            @if($field === 'status' && isset($user[$field]))
                                                                <span class="badge {{ $user[$field] === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                                    {{ ucfirst($user[$field]) }}
                                                                </span>
                                                            @else
                                                                {{ $user[$field] ?? 'N/A' }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @else
                                                    <td>{{ $user->User_ID ?? 'N/A' }}</td>
                                                    <td>{{ $user->Name ?? 'N/A' }}</td>
                                                    <td>{{ $user->Email ?? 'N/A' }}</td>
                                                    <td>{{ $user->Contact_Number ?? 'N/A' }}</td>
                                                    <td>{{ $user->publicUser->Ic_Number ?? 'N/A' }}</td>
                                                    <td>{{ $user->agency->Address ?? 'N/A' }}</td>
                                                    <td>{{ $user->User_Type ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge {{ strtolower($user->Status) === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $user->Status ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Data Available</h3>
                            <p>No users found matching the selected criteria.</p>
                        </div>
                    @endif
                @endif

                {{-- Agencies Report --}}
                @if(isset($agencies))
                        @if(count($agencies) > 0)
                            <div class="report-table-container">
                                <div class="table-header">
                                    <h3><i class="fas fa-building"></i> Agencies Report</h3>
                                </div>
                                <div class="table-container">
                                    <table class="report-table">
                                    <thead>
                                        <tr>
                                            @if(isset($selected_fields))
                                                @foreach($selected_fields as $field)
                                                    <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                                                @endforeach
                                            @else
                                                <th>ID</th>
                                                <th>Agency Name</th>
                                                <th>Agency Type</th>
                                                <th>Contact Person</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Registered Date</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($agencies as $agency)
                                            <tr>
                                                @if(isset($selected_fields))
                                                    @foreach($selected_fields as $field)
                                                        <td>
                                                            @if($field === 'status' && isset($agency[$field]))
                                                                <span class="badge {{ $agency[$field] === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                                    {{ ucfirst($agency[$field]) }}
                                                                </span>
                                                            @else
                                                                {{ $agency[$field] ?? 'N/A' }}
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @else
                                                    <td>{{ $agency->Agency_ID ?? 'N/A' }}</td>
                                                    <td>{{ $agency->Agency_Section ?? 'N/A' }}</td>
                                                    <td>Government Agency</td>
                                                    <td>{{ $agency->user->Name ?? 'N/A' }}</td>
                                                    <td>{{ $agency->user->Email ?? 'N/A' }}</td>
                                                    <td>{{ $agency->user->Contact_Number ?? 'N/A' }}</td>
                                                    <td>{{ $agency->Address ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge {{ strtolower($agency->user->Status ?? 'unknown') === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $agency->user->Status ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $agency->Register_Date ? $agency->Register_Date->format('d/m/Y') : 'N/A' }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Data Available</h3>
                            <p>No agencies found matching the selected criteria.</p>
                        </div>
                    @endif
                @endif

                {{-- System Report --}}
                @if(isset($system_data))
                        <!-- System Statistics -->
                        @if(isset($system_data['total_users']) || isset($system_data['total_agencies']) || isset($system_data['active_users']) || isset($system_data['recent_registrations']))
                        <div class="stats-grid">
                            @if(isset($system_data['total_users']))
                            <div class="stat-card">
                                <i class="fas fa-users"></i>
                                <div class="stat-number">{{ $system_data['total_users'] }}</div>
                                <div class="stat-label">Total Users</div>
                            </div>
                            @endif
                            @if(isset($system_data['total_agencies']))
                            <div class="stat-card">
                                <i class="fas fa-building"></i>
                                <div class="stat-number">{{ $system_data['total_agencies'] }}</div>
                                <div class="stat-label">Total Agencies</div>
                            </div>
                            @endif
                            @if(isset($system_data['active_users']))
                            <div class="stat-card">
                                <i class="fas fa-check-circle"></i>
                                <div class="stat-number">{{ $system_data['active_users'] }}</div>
                                <div class="stat-label">Active Users</div>
                            </div>
                            @endif
                            @if(isset($system_data['recent_registrations']))
                            <div class="stat-card">
                                <i class="fas fa-calendar-plus"></i>
                                <div class="stat-number">{{ $system_data['recent_registrations'] }}</div>
                                <div class="stat-label">Recent Registrations (30 days)</div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- System Information -->
                        @if(isset($system_data['system_version']) || isset($system_data['php_version']) || isset($system_data['laravel_version']) || isset($system_data['database_type']) || isset($system_data['server_info']) || isset($system_data['report_generated']))
                        <div class="system-info">
                            <h3><i class="fas fa-info-circle"></i> System Information</h3>
                            @if(isset($system_data['system_version']))
                            <div class="info-row">
                                <strong>System Version:</strong>
                                <span>{{ $system_data['system_version'] }}</span>
                            </div>
                            @endif
                            @if(isset($system_data['php_version']))
                            <div class="info-row">
                                <strong>PHP Version:</strong>
                                <span>{{ $system_data['php_version'] }}</span>
                            </div>
                            @endif
                            @if(isset($system_data['laravel_version']))
                            <div class="info-row">
                                <strong>Laravel Version:</strong>
                                <span>{{ $system_data['laravel_version'] }}</span>
                            </div>
                            @endif
                            @if(isset($system_data['database_type']))
                            <div class="info-row">
                                <strong>Database:</strong>
                                <span>{{ $system_data['database_type'] }}</span>
                            </div>
                            @endif
                            @if(isset($system_data['server_info']))
                            <div class="info-row">
                                <strong>Server:</strong>
                                <span>{{ $system_data['server_info'] }}</span>
                            </div>
                            @endif
                            @if(isset($system_data['report_generated']))
                            <div class="info-row">
                                <strong>Report Generated:</strong>
                                <span>{{ $system_data['report_generated'] }}</span>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Database Statistics -->
                        @if(isset($system_data['database_stats']))
                        <div class="system-info">
                            <h3><i class="fas fa-database"></i> Database Statistics</h3>
                            @foreach($system_data['database_stats'] as $table => $count)
                            <div class="info-row">
                                <strong>{{ ucfirst(str_replace('_', ' ', $table)) }}:</strong>
                                <span>{{ number_format($count) }} records</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @endif
                </div>

            @else
                {{-- Dashboard Mode --}}
                {{-- Statistics Overview --}}
                @if(isset($stats))
                <div class="stats-grid">
                    <div class="stat-card stat-total">
                        <i class="fas fa-users"></i>
                        <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-card stat-agencies">
                        <i class="fas fa-building"></i>
                        <div class="stat-number">{{ $stats['total_agencies'] ?? 0 }}</div>
                        <div class="stat-label">Total Agencies</div>
                    </div>
                    <div class="stat-card stat-active">
                        <i class="fas fa-user-check"></i>
                        <div class="stat-number">{{ $stats['active_users'] ?? 0 }}</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                    <div class="stat-card stat-recent">
                        <i class="fas fa-calendar-plus"></i>
                        <div class="stat-number">{{ $stats['recent_registrations'] ?? 0 }}</div>
                        <div class="stat-label">Recent (30 days)</div>
                    </div>
                </div>
                @endif

                {{-- Report Navigation Tabs --}}
                <div class="report-navigation">
                    <div class="nav-tabs">
                        <button class="nav-tab active" data-tab="users">
                            <i class="fas fa-users"></i>
                            <span>Users Report</span>
                        </button>
                        <button class="nav-tab" data-tab="agencies">
                            <i class="fas fa-building"></i>
                            <span>Agencies Report</span>
                        </button>
                        <button class="nav-tab" data-tab="system">
                            <i class="fas fa-cogs"></i>
                            <span>System Report</span>
                        </button>
                        <button class="nav-tab" data-tab="custom">
                            <i class="fas fa-magic"></i>
                            <span>Custom Report</span>
                        </button>
                    </div>
                </div>

                {{-- Tab Content Sections --}}
                <div class="tab-content-container">
                    {{-- Users Report Tab --}}
                    <div id="users-content" class="tab-content active">
                        <div class="report-section">
                            <div class="section-header">
                                <h2><i class="fas fa-users"></i> Users Report</h2>
                                <p>Generate comprehensive reports about all registered users in the system.</p>
                            </div>
                            
                            <div class="report-options">
                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>All Users Report</h3>
                                        <p>Complete list of all registered users with their profiles and registration details.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'html', 'user_type' => 'all']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'pdf', 'user_type' => 'all']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="{{ route('mcmc.reports.users.csv', ['user_type' => 'all']) }}" class="btn btn-info">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>Agency Users Report</h3>
                                        <p>Report focusing on users from government agencies and their roles.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'html', 'user_type' => 'agency']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'pdf', 'user_type' => 'agency']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="{{ route('mcmc.reports.users.csv', ['user_type' => 'agency']) }}" class="btn btn-info">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>Public Users Report</h3>
                                        <p>Report focusing on public users and their activity in the system.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'html', 'user_type' => 'public']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.users', ['format' => 'pdf', 'user_type' => 'public']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="{{ route('mcmc.reports.users.csv', ['user_type' => 'public']) }}" class="btn btn-info">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Agencies Report Tab --}}
                    <div id="agencies-content" class="tab-content">
                        <div class="report-section">
                            <div class="section-header">
                                <h2><i class="fas fa-building"></i> Agencies Report</h2>
                                <p>Generate comprehensive reports about all registered government agencies.</p>
                            </div>
                            
                            <div class="report-options">
                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>All Agencies Report</h3>
                                        <p>Complete list of all registered government agencies with their details and contact information.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.agencies', ['format' => 'html']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.agencies', ['format' => 'pdf']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <button onclick="exportAgenciesData()" class="btn btn-info">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>Active Agencies Report</h3>
                                        <p>Report focusing on currently active agencies and their engagement levels.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.agencies', ['format' => 'html', 'status' => 'active']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.agencies', ['format' => 'pdf', 'status' => 'active']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <button onclick="exportAgenciesData('active')" class="btn btn-info">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- System Report Tab --}}
                    <div id="system-content" class="tab-content">
                        <div class="report-section">
                            <div class="section-header">
                                <h2><i class="fas fa-cogs"></i> System Report</h2>
                                <p>Generate comprehensive system analytics and performance statistics.</p>
                            </div>
                            
                            <div class="report-options">
                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>System Analytics Report</h3>
                                        <p>Comprehensive system statistics, database information, and platform analytics.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.system', ['format' => 'html']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.system', ['format' => 'pdf']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card">
                                    <div class="card-icon">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div class="card-content">
                                        <h3>Database Statistics</h3>
                                        <p>Detailed database performance metrics and storage information.</p>
                                        <div class="card-actions">
                                            <a href="{{ route('mcmc.reports.system', ['format' => 'html', 'type' => 'database']) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> View Report
                                            </a>
                                            <a href="{{ route('mcmc.reports.system', ['format' => 'pdf', 'type' => 'database']) }}" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Custom Report Tab --}}
                    <div id="custom-content" class="tab-content">
                        <div class="custom-form">
                            <div class="section-header">
                                <h2><i class="fas fa-magic"></i> Custom Report Generator</h2>
                                <p>Create customized reports by selecting specific fields, filters, and output formats.</p>
                            </div>
                        
                        <form id="customReportForm" method="GET" action="{{ route('mcmc.reports.custom') }}">
                            <div class="form-row">
                                <!-- Report Type Selection -->
                                <div class="form-group">
                                    <label><i class="fas fa-clipboard-list"></i> Report Type</label>
                                    <div class="checkboxes-group">
                                        <div class="checkbox-item">
                                            <input type="radio" name="report_type" id="users_report" value="users" checked onchange="toggleReportOptions()">
                                            <label for="users_report">
                                                <i class="fas fa-users"></i> Users Report
                                            </label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="radio" name="report_type" id="agencies_report" value="agencies" onchange="toggleReportOptions()">
                                            <label for="agencies_report">
                                                <i class="fas fa-building"></i> Agencies Report
                                            </label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="radio" name="report_type" id="system_report" value="system" onchange="toggleReportOptions()">
                                            <label for="system_report">
                                                <i class="fas fa-cogs"></i> System Report
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            <!-- Field Selection -->
                            <div class="col-md-4">
                                <div class="report-card">
                                    <h4><i class="fas fa-list"></i> Select Fields</h4>
                                    
                                    <!-- Users Fields -->
                                    <div id="users_fields" class="field-options">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="id" id="user_id" checked>
                                            <label class="form-check-label" for="user_id">ID</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="name" id="user_name" checked>
                                            <label class="form-check-label" for="user_name">Name</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="email" id="user_email" checked>
                                            <label class="form-check-label" for="user_email">Email</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="phone" id="user_phone">
                                            <label class="form-check-label" for="user_phone">Phone</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="ic_number" id="user_ic">
                                            <label class="form-check-label" for="user_ic">IC Number</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="address" id="user_address">
                                            <label class="form-check-label" for="user_address">Address</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="agency" id="user_agency">
                                            <label class="form-check-label" for="user_agency">Agency</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="status" id="user_status" checked>
                                            <label class="form-check-label" for="user_status">Status</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="users_fields[]" value="created_at" id="user_created" checked>
                                            <label class="form-check-label" for="user_created">Registration Date</label>
                                        </div>
                                    </div>

                                    <!-- Agencies Fields -->
                                    <div id="agencies_fields" class="field-options" style="display: none;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="id" id="agency_id" checked>
                                            <label class="form-check-label" for="agency_id">ID</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="agency_name" id="agency_name" checked>
                                            <label class="form-check-label" for="agency_name">Agency Name</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="agency_type" id="agency_type">
                                            <label class="form-check-label" for="agency_type">Agency Type</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="contact_person" id="agency_contact">
                                            <label class="form-check-label" for="agency_contact">Contact Person</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="email" id="agency_email" checked>
                                            <label class="form-check-label" for="agency_email">Email</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="phone" id="agency_phone">
                                            <label class="form-check-label" for="agency_phone">Phone</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="address" id="agency_address">
                                            <label class="form-check-label" for="agency_address">Address</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="status" id="agency_status" checked>
                                            <label class="form-check-label" for="agency_status">Status</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agencies_fields[]" value="created_at" id="agency_created" checked>
                                            <label class="form-check-label" for="agency_created">Registration Date</label>
                                        </div>
                                    </div>

                                    <!-- System Fields -->
                                    <div id="system_fields" class="field-options" style="display: none;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="total_users" id="sys_total_users" checked>
                                            <label class="form-check-label" for="sys_total_users">Total Users</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="total_agencies" id="sys_total_agencies" checked>
                                            <label class="form-check-label" for="sys_total_agencies">Total Agencies</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="active_users" id="sys_active_users" checked>
                                            <label class="form-check-label" for="sys_active_users">Active Users</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="recent_registrations" id="sys_recent" checked>
                                            <label class="form-check-label" for="sys_recent">Recent Registrations</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="system_info" id="sys_info" checked>
                                            <label class="form-check-label" for="sys_info">System Information</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="system_fields[]" value="database_stats" id="sys_db_stats">
                                            <label class="form-check-label" for="sys_db_stats">Database Statistics</label>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllFields()">
                                            <i class="fas fa-check-double"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearAllFields()">
                                            <i class="fas fa-times"></i> Clear All
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Filters & Options -->
                            <div class="col-md-4">
                                <div class="report-card">
                                    <h4><i class="fas fa-filter"></i> Filters & Options</h4>
                                    
                                    <!-- Date Range Filter -->
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-calendar"></i> Date Range</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" class="form-control form-control-sm" name="start_date" placeholder="Start Date">
                                            </div>
                                            <div class="col-6">
                                                <input type="date" class="form-control form-control-sm" name="end_date" placeholder="End Date">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="mb-3" id="status_filter">
                                        <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
                                        <select class="form-select form-select-sm" name="status_filter">
                                            <option value="">All Status</option>
                                            <option value="active">Active Only</option>
                                            <option value="inactive">Inactive Only</option>
                                            <option value="pending">Pending Only</option>
                                        </select>
                                    </div>

                                    <!-- User Type Filter (for users report) -->
                                    <div class="mb-3" id="user_type_filter">
                                        <label class="form-label"><i class="fas fa-user-tag"></i> User Type</label>
                                        <select class="form-select form-select-sm" name="user_type_filter">
                                            <option value="">All Users</option>
                                            <option value="public">Public Users</option>
                                            <option value="agency">Agency Users</option>
                                        </select>
                                    </div>

                                    <!-- Sorting Options -->
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-sort"></i> Sort By</label>
                                        <select class="form-select form-select-sm" name="sort_by" id="sort_by">
                                            <option value="created_at">Registration Date</option>
                                            <option value="name">Name</option>
                                            <option value="email">Email</option>
                                            <option value="status">Status</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-sort-amount-down"></i> Sort Order</label>
                                        <select class="form-select form-select-sm" name="sort_order">
                                            <option value="desc">Newest First</option>
                                            <option value="asc">Oldest First</option>
                                        </select>
                                    </div>

                                    <!-- Limit Results -->
                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-list-ol"></i> Limit Results</label>
                                        <select class="form-select form-select-sm" name="limit">
                                            <option value="">All Records</option>
                                            <option value="50">50 Records</option>
                                            <option value="100">100 Records</option>
                                            <option value="500">500 Records</option>
                                            <option value="1000">1000 Records</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Report Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="report-card text-center">
                                    <h4><i class="fas fa-download"></i> Generate Custom Report</h4>
                                    <p>Click below to generate your customized report with selected options.</p>
                                    
                                    <div class="btn-group">
                                        <button type="submit" name="format" value="html" class="btn btn-primary btn-lg">
                                            <i class="fas fa-eye"></i> Preview Report
                                        </button>
                                        <button type="submit" name="format" value="pdf" class="btn btn-success btn-lg">
                                            <i class="fas fa-file-pdf"></i> Download PDF
                                        </button>
                                        <button type="submit" name="format" value="csv" class="btn btn-warning btn-lg">
                                            <i class="fas fa-file-csv"></i> Export CSV
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        {{-- Close tab content container --}}
        </div>
        {{-- Close reports dashboard --}}
        </div>

        {{-- JavaScript (only for HTML mode) --}}
        <script>
            // Enhanced Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Add click event listeners to nav tabs
                const navTabs = document.querySelectorAll('.nav-tab');
                navTabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const tabName = this.getAttribute('data-tab');
                        showTab(tabName);
                    });
                });
            });

            function showTab(tabName) {
                // Hide all tab contents
                const tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Remove active class from all nav tabs
                const navTabs = document.querySelectorAll('.nav-tab');
                navTabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                
                // Show selected tab content
                const selectedTab = document.getElementById(tabName + '-content');
                if (selectedTab) {
                    selectedTab.classList.add('active');
                }
                
                // Add active class to selected nav tab
                const selectedNavTab = document.querySelector(`[data-tab="${tabName}"]`);
                if (selectedNavTab) {
                    selectedNavTab.classList.add('active');
                }
            }

            function exportAgenciesData() {
                // Create a temporary form for agencies CSV export
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '{{ route("mcmc.reports.users.csv") }}';
                
                const sectionInput = document.createElement('input');
                sectionInput.type = 'hidden';
                sectionInput.name = 'user_type';
                sectionInput.value = 'agency';
                form.appendChild(sectionInput);
                
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }

            // Custom report functions
            function toggleReportOptions() {
                const reportType = document.querySelector('input[name="report_type"]:checked').value;
                
                // Hide all field options
                document.querySelectorAll('.field-options').forEach(el => el.style.display = 'none');
                
                // Show relevant field options
                document.getElementById(reportType + '_fields').style.display = 'block';
                
                // Show/hide filters based on report type
                const userTypeFilter = document.getElementById('user_type_filter');
                const statusFilter = document.getElementById('status_filter');
                const sortBy = document.getElementById('sort_by');
                
                if (reportType === 'users') {
                    userTypeFilter.style.display = 'block';
                    statusFilter.style.display = 'block';
                    // Update sort options for users
                    sortBy.innerHTML = `
                        <option value="created_at">Registration Date</option>
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="status">Status</option>
                    `;
                } else if (reportType === 'agencies') {
                    userTypeFilter.style.display = 'none';
                    statusFilter.style.display = 'block';
                    // Update sort options for agencies
                    sortBy.innerHTML = `
                        <option value="created_at">Registration Date</option>
                        <option value="agency_name">Agency Name</option>
                        <option value="agency_type">Agency Type</option>
                        <option value="status">Status</option>
                    `;
                } else if (reportType === 'system') {
                    userTypeFilter.style.display = 'none';
                    statusFilter.style.display = 'none';
                    // Update sort options for system
                    sortBy.innerHTML = `
                        <option value="metric">Metric</option>
                        <option value="value">Value</option>
                    `;
                }
            }

            function selectAllFields() {
                const reportType = document.querySelector('input[name="report_type"]:checked').value;
                const checkboxes = document.querySelectorAll(`#${reportType}_fields input[type="checkbox"]`);
                checkboxes.forEach(checkbox => checkbox.checked = true);
            }

            function clearAllFields() {
                const reportType = document.querySelector('input[name="report_type"]:checked').value;
                const checkboxes = document.querySelectorAll(`#${reportType}_fields input[type="checkbox"]`);
                checkboxes.forEach(checkbox => checkbox.checked = false);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey) {
                    switch(event.key) {
                        case '1':
                            event.preventDefault();
                            showTab('users');
                            break;
                        case '2':
                            event.preventDefault();
                            showTab('agencies');
                            break;
                        case '3':
                            event.preventDefault();
                            showTab('system');
                            break;
                        case '4':
                            event.preventDefault();
                            showTab('custom');
                            break;
                    }
                }
            });

            // Form validation
            document.getElementById('customReportForm').addEventListener('submit', function(event) {
                const reportType = document.querySelector('input[name="report_type"]:checked').value;
                const fieldName = reportType + '_fields[]';
                const selectedFields = document.querySelectorAll(`input[name="${fieldName}"]:checked`);
                
                if (selectedFields.length === 0) {
                    event.preventDefault();
                    alert('Please select at least one field to include in the report.');
                    return false;
                }
            });

            // Go back to custom report configuration
            function goBackToCustom() {
                // Go back to reports page and show custom tab
                window.location.href = '{{ route("mcmc.reports") }}#custom';
            }

            // URL fragment and keyboard shortcuts
            document.addEventListener('DOMContentLoaded', function() {
                // Check for URL fragment on page load
                const hash = window.location.hash;
                if (hash === '#custom') {
                    showTab('custom');
                } else if (hash === '#agencies') {
                    showTab('agencies');
                } else if (hash === '#system') {
                    showTab('system');
                } else if (hash === '#users') {
                    showTab('users');
                }

                // Add keyboard shortcuts
                document.addEventListener('keydown', function(event) {
                    if (event.ctrlKey || event.metaKey) {
                        switch(event.key) {
                            case '1':
                                event.preventDefault();
                                showTab('users');
                                break;
                            case '2':
                                event.preventDefault();
                                showTab('agencies');
                                break;
                            case '3':
                                event.preventDefault();
                                showTab('system');
                                break;
                            case '4':
                                event.preventDefault();
                                showTab('custom');
                                break;
                        }
                    }
                });
            });
        </script>
    @endif
</body>
</html>