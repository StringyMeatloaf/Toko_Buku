<section class="bg-white p-6 rounded-xl shadow-sm border mb-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Tren Inventaris
            </h2>

            <p class="text-gray-500">
                Perbandingan buku masuk vs buku terjual
            </p>

        </div>

        <div class="flex gap-3">

            <button
                class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200">

                Export PDF

            </button>

            <select class="px-4 py-2 rounded-lg border">

                <option>2025</option>
                <option>2024</option>

            </select>

        </div>

    </div>

    <div class="h-[350px]">

        <canvas id="inventoryChart"></canvas>

    </div>

</section>