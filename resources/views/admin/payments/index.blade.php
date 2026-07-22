<x-layouts.admin>
  <x-slot:title>Payment Confirmations</x-slot:title>

  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900">Payment Confirmations</h1>
    <p class="text-sm text-gray-500 mt-1">Review pending payments and view confirmed transaction history.</p>
  </div>

  @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <!-- Pending Payments -->
  <div class="bg-white shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Pending Payments</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 text-left">
            <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Car</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Method</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Fee</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Gift Card</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Proof</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Date</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pendingPayments as $payment)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-900">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($payment->full_name, 0, 1)) }}
                  </div>
                  {{ $payment->full_name }}
                </div>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $payment->email }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $payment->car_name }}</td>
              <td class="px-4 py-3 text-gray-600 capitalize">{{ $payment->payment_method }}</td>
              <td class="px-4 py-3 text-gray-900 font-semibold">{{ $payment->car_fee }}</td>
              <td class="px-4 py-3">
                @if($payment->giftCardType)
                  <div class="text-xs">
                    <span class="font-semibold text-gray-700">{{ $payment->giftCardType->name }}</span>
                    @if($payment->gift_card_code)
                      <br><span class="font-mono text-gray-500">{{ $payment->gift_card_code }}</span>
                    @endif
                  </div>
                @else
                  <span class="text-xs text-gray-400">—</span>
                @endif
              </td>
              <td class="px-4 py-3">
                @if(!empty($payment->payment_proof))
                  <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="inline-block border border-gray-200 hover:border-red-500 transition-colors">
                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment proof" class="h-12 w-12 object-cover">
                  </a>
                @else
                  <span class="text-xs text-gray-400">No proof</span>
                @endif
              </td>
              <td class="px-4 py-3 text-gray-500">{{ $payment->created_at->format('M d, Y') }}</td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <form method="POST" action="{{ route('admin.payments.confirm', $payment) }}">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-1.5 text-xs transition-colors">
                      Confirm
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" onsubmit="return confirm('Are you sure you want to reject this payment?');">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-1.5 text-xs transition-colors">
                      Reject
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-4 py-8 text-center text-gray-400">No pending payments.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Transaction History -->
  <div class="bg-white shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Transaction History</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-gray-50 text-left">
            <th class="px-4 py-3 font-semibold text-gray-600">Name</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Car</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Method</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Fee</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Gift Card</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Proof</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Confirmed At</th>
            <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($transactionHistory as $payment)
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-900">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($payment->full_name, 0, 1)) }}
                  </div>
                  {{ $payment->full_name }}
                </div>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ $payment->email }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $payment->car_name }}</td>
              <td class="px-4 py-3 text-gray-600 capitalize">{{ $payment->payment_method }}</td>
              <td class="px-4 py-3 text-gray-900 font-semibold">{{ $payment->car_fee }}</td>
              <td class="px-4 py-3">
                @if($payment->giftCardType)
                  <div class="text-xs">
                    <span class="font-semibold text-gray-700">{{ $payment->giftCardType->name }}</span>
                    @if($payment->gift_card_code)
                      <br><span class="font-mono text-gray-500">{{ $payment->gift_card_code }}</span>
                    @endif
                  </div>
                @else
                  <span class="text-xs text-gray-400">—</span>
                @endif
              </td>
              <td class="px-4 py-3">
                @if(!empty($payment->payment_proof))
                  <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="inline-block border border-gray-200 hover:border-red-500 transition-colors">
                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment proof" class="h-12 w-12 object-cover">
                  </a>
                @else
                  <span class="text-xs text-gray-400">No proof</span>
                @endif
              </td>
              <td class="px-4 py-3 text-gray-500">{{ $payment->updated_at->format('M d, Y h:i A') }}</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                  Confirmed
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-4 py-8 text-center text-gray-400">No confirmed transactions yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-layouts.admin>
