<x-app-layout>
 

    <div class="min-h-screen bg-linear-to-br from-slate-50 to-slate-100">
        <!-- Hero Section -->
        <div class="max-w-6xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 mb-6">
                    Custom Algo Trading <span class="text-blue-600">TradeWithAI</span>
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

        <!-- Footer -->
          <footer class="border-t mt-20">
            <div class="max-w-7xl mx-auto px-6 py-10">

                <div class="grid gap-8 md:grid-cols-4">

                    <!-- Brand -->
                    <div>
                        <h3 class="text-lg font-semibold">Trade With AI</h3>
                        <p class="mt-3 text-sm text-zinc-500">
                            
                        </p>
                    </div>

                    <!-- Learn -->
                    <div>
                        <h4 class="font-medium">Learn</h4>

                        <ul class="mt-3 space-y-2 text-sm text-zinc-500">
                            
                            <li>
                                <flux:link href="{{route('login')}}">Tutorials</flux:link> 
                            </li>
                            <li>
                                <flux:link href="{{route('posts')}}">Posts</flux:link> 
                            </li>
                            
                        </ul>
                    </div>

                    <!-- AI -->
                    <div>
                        <h4 class="font-medium">AI</h4>

                        <ul class="mt-3 space-y-2 text-sm text-zinc-500">
                            <li>
                                <flux:link href="{{route('login')}}">Try Ai</flux:link> 
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h4 class="font-medium">Legal</h4>

                        <ul class="mt-3 space-y-2 text-sm text-zinc-500">
                            <li>
                                <flux:link href="{{route('privacy-policy')}}">Privacy Policy</flux:link> 
                            </li>
                            <li>
                                <flux:link href="{{route('terms-and-conditions')}}">
                                    Terms of Service
                                </flux:link> 
                            </li>
                            <li>
                                <flux:link href="{{route('refund-policy')}}">
                                    Refund Policy
                                </flux:link> 
                            </li>
                            
                            <li>
                                <flux:link href="mailto:support@tradewithai.co.in" class="hover:underline">
                                    support@tradewithai.co.in
                                </flux:link>

                                <div class="mt-3 rounded-lg border bg-zinc-50 dark:bg-zinc-800 px-4 py-3 shadow-sm text-xs text-zinc-600 dark:text-zinc-300">
                                    <strong>Response Time:</strong> We typically reply within <strong>6 hours</strong>.
                                    
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="mt-10 border-t pt-6 text-center text-sm text-zinc-500">
                    © {{ date('Y') }} tradewithai.co.in. All rights reserved.
                    <flux:separator variant="subtle" />
                    TradeWithAI is an independent educational and technology platform and is not a SEBI-registered investment adviser, broker, or financial advisor. The platform is intended for educational purposes only. Users are solely responsible for their own investment decisions and use the platform at their own risk. No investment returns are guaranteed. All trademarks are the property of their respective owners.
                </div>

            </div>
        </footer>

         <!-- Footer -->
        
    </div>
</x-app-layout>
