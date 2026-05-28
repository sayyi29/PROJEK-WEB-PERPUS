<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.reports')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; color: black; }
        }
    </style>
</head>
<body class="bg-white text-black p-10" onload="window.print()">
    <div class="max-w-5xl mx-auto">
        <div class="text-center border-b-2 border-black pb-8 mb-10">
            <h1 class="text-3xl font-black uppercase tracking-tighter">@lang('messages.library_circulation_report')</h1>
            <p class="text-sm font-bold text-gray-600 mt-2 uppercase tracking-widest">@lang('messages.period'): {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        </div>

        <table class="w-full border-collapse border border-gray-300 mb-10">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black">No</th>
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black text-left">@lang('messages.borrower')</th>
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black text-left">@lang('messages.book_label')</th>
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black">@lang('messages.borrow_date_short')</th>
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black">@lang('messages.return_date_short')</th>
                    <th class="border border-gray-300 px-4 py-2 text-xs uppercase font-black">@lang('messages.status')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $index => $b)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-xs text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-xs font-bold">{{ $b->user->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-xs italic">{{ $b->book->title }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-xs text-center">{{ $b->borrow_date->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-xs text-center">{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-xs text-center uppercase font-bold">{{ $b->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-20">
            <div class="text-center w-64">
                <p class="text-xs uppercase font-black mb-20 text-gray-600">@lang('messages.printed_at'): {{ date('d F Y') }}</p>
                <div class="border-b border-black w-full"></div>
                <p class="text-xs font-black mt-2 uppercase">@lang('messages.library_staff')</p>
            </div>
        </div>
        
        <div class="no-print mt-10 flex justify-center">
            <button onclick="window.history.back()" class="px-8 py-3 bg-gray-800 text-white font-bold rounded-xl">@lang('messages.go_back')</button>
        </div>
    </div>
</body>
</html>
