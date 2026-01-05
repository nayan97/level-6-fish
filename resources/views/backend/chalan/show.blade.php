<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ইনভয়েস</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&display=swap');

        body {
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        /* Screen styles */
        .main-border {
            border: 18px solid #fff;
        }

        .invoice-paper {
            background:
                linear-gradient(#fff, #fff) padding-box,
                linear-gradient(to right, #8C5E60, #95AFC0) border-box;
            border: 16px solid transparent;
        }

        /* Watermark */
        .watermark::before {
            content: "কলম মৎস্য আড়ৎ";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 3rem;
            color: rgba(53, 48, 48, 0.15);
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }
        /* .fish-watermark {
            background-image: url("{{ asset('assets/img/watermark.png') }}");
            background-repeat: no-repeat;

      
            background-position: center 100px;

            background-size: 900px 600px;
            opacity: 1;
            position: relative;

        } */

        .invoice-paper>* {
            position: relative;
            z-index: 1;
        }

        /* ================= PRINT FIX ================= */
        @media print {

            body {
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            .main-border {
                border: 18px solid #fff !important;
            }

            .invoice-paper {
                background:
                    linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(to right, #8C5E60, #95AFC0) border-box;
                border: 16px solid transparent;
            }



            table {
                width: 100% !important;
                border-collapse: collapse !important;
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid !important;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }
    </style>

</head>

<body class="bg-gray-100 font-sans leading-normal text-gray-800">

    <div class="main-border main-border max-w-4xl mx-auto mt-[50px]">
        <div class="p-8 bg-white shadow-lg rounded-xl watermark fish-watermark invoice-paper">

            <!-- Header -->
            <header class="text-center border-b-2 border-gray-300 pb-4 mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">কলম মৎস্য আড়ৎ</h1>
                <p class="text-md mb-1 bg-[#DEA290] max-w-80 mx-auto rounded-full py-2 text-white">প্রোপ: মোঃ শাহাদৎ
                    হোসেন (শাবান)</p>
                <p class="text-sm text-gray-500 mb-1">মোবাইল নং: ০১৭২৫-৭৯০৮৬৯, ০১৭৩২-৭৮৫০৬১, ০১৭০২-৭৮০৮৮৭</p>
                <p class="text-sm text-gray-500">ঠিকানা: সিংড়া, বাসস্ট্যান্ড, সিংড়া, নাটোর।</p>
            </header>

            <!-- Invoice Details -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <div class="w-full sm:w-1/3 mb-4 sm:mb-0">
                    <p class="text-sm"><strong>মহাজন:</strong> <span
                            class="text-gray-600">{{ $chalan->mohajon->name ?? 'N/A' }}</span></p>
                </div>
                <div class="w-full sm:w-1/3 mb-4 sm:mb-0 text-center">
                    <p class="text-sm"><strong>ইনভয়েস নম্বর:</strong> <span
                            class="text-gray-600">{{ $chalan->invoice_no }}</span></p>
                </div>
                <div class="w-full sm:w-1/3 text-right">
                    <p class="text-sm"><strong>তারিখ:</strong> <span
                            class="text-gray-600">{{ \Carbon\Carbon::parse($chalan->chalan_date)->format('d M Y') }}</span>
                    </p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">পণ্যের তালিকা</h2>
                <table class="w-full text-left table-auto border-collapse">
                    <thead>
                        <tr class="bg-[#DEA290] text-white">
                            <th class="py-3 px-4 border-b font-medium text-sm text-white rounded-tl-lg">#</th>
                            <th class="py-3 px-4 border-b font-medium text-sm text-white">পণ্যের নাম</th>
                            <th class="py-3 px-4 border-b font-medium text-sm text-white text-center">পরিমাণ</th>
                            <th class="py-3 px-4 border-b font-medium text-sm text-white text-right">মূল্য</th>
                            <th class="py-3 px-4 border-b font-medium text-sm text-white text-right rounded-tr-lg">
                                মোট মূল্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse($chalan->chalan_items as $item)
                            <?php
                            $total += $item->quantity;
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 border-b text-sm text-gray-700">{{ $item->item_name }}</td>
                                <td class="py-3 px-4 border-b text-sm text-gray-700 text-center">
                                    {{ number_format($item->quantity, 2) }} কেজি</td>
                                <td class="py-3 px-4 border-b text-sm text-gray-700 text-right">
                                    {{ number_format($item->unit_price, 2) }} টাকা</td>
                                <td class="py-3 px-4 border-b text-sm text-gray-700 text-right">
                                    {{ number_format($item->quantity * $item->unit_price, 2) }} টাকা</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">কোনো পণ্য পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">মোট :</th>
                            <th class="text-center">{{ number_format($total, 2) }} কেজি</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Expense and Total Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start mb-8">
                <div class="w-full sm:w-1/2 md:w-2/3 mb-4 sm:mb-0 pr-0 sm:pr-8">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">খরচের বিবরণ</h2>
                    @forelse($chalan->chalan_expenses as $expense)
                        <div class="flex justify-between py-2 items-center">
                            <span class="text-sm text-gray-600">{{ $expense->expense_type }}:</span>
                            <span class="text-sm font-semibold text-gray-800">{{ number_format($expense->amount, 2) }}
                                টাকা</span>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1;" class="text-center text-muted">কোনো খরচ পাওয়া যায়নি।
                        </div>
                    @endforelse
                    <!-- Add more expenses here as needed -->
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between py-2 border-b border-gray-300">
                        <span class="text-sm text-gray-600">যাবতীয় খরচ:</span>
                        <span
                            class="text-sm font-semibold text-gray-800">{{ number_format($chalan->total_expense, 2) }}
                            টাকা</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-300">
                        <span class="text-sm text-gray-600">কাঁচা বিক্রয়:</span>
                        <span class="text-sm font-semibold text-gray-800">{{ number_format($chalan->subtotal, 2) }}
                            টাকা</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-300">
                        <span class="text-sm text-gray-600">পাকা বিক্রয়:</span>
                        <span class="text-sm font-semibold text-gray-800">{{ number_format($chalan->total_amount, 2) }}
                            টাকা</span>
                    </div>
                    <div class="text-center mt-4">
                        <p class="text-lg font-bold text-pink-600">পেমেন্ট:
                            {{ number_format($chalan->payment_amount, 2) }} টাকা</p>
                    </div>
                </div>
            </div>

            <!-- Print Button (non-printable) -->
            <div class="no-print mt-8 text-center">
                <a href="javascript:history.back()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 mr-2">
                    Back
                </a>
                <button onclick="window.print()"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                    Print Invoice
                </button>
            </div>

        </div>
    </div>

</body>

</html>
