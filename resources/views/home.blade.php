@extends('app')
@section('content')
    <div class="min-h-screen bg-linear-to-br from-slate-50 to-slate-100">
        <!-- Hero Section -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 mb-6">
                    Welcome to <span class="text-blue-600">TradeWithAI</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto mb-8">
                    Revolutionize your trading experience with the power of artificial intelligence. Make smarter decisions, faster.
                </p>
                 <div class="flex flex-col sm:flex-row gap-4 justify-center">
    
                    <a href="https://live.tradewithai.co.in"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center px-8 py-3 bg-white text-slate-700 font-semibold rounded-lg border-2 border-slate-200 hover:border-blue-600 hover:text-blue-600 transition-colors">
                        📈 View Live Charts
                    </a>

                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-slate-900 text-center mb-12">Why Choose TradeWithAI?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Lightning Fast Analysis</h3>
                    <p class="text-slate-600">Get real-time market insights powered by advanced AI algorithms.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Smart Predictions</h3>
                    <p class="text-slate-600">AI-powered predictions to help you make informed trading decisions.</p>
                </div>

                
            </div>
        </div>

        
    </div>
@endsection
