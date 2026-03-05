<!DOCTYPE html>
<html lang="ja">
<?php 
// ページタイトルを設定してheadを読み込む
$page_title = "書籍検索";
include 'includes/head.php'; 
?>
<body class="bg-[#f4f6f9] text-[#3e3e3c] h-screen overflow-hidden flex">
    <!-- この一行は、「画面全体の土台の見た目」と「パーツの並べ方」を一気に決定している非常に重要なコードです。使われているのはすべて Tailwind CSS のクラス名です。 -->

    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-1 flex flex-col overflow-hidden">
        <?php include 'includes/header.php'; ?>

        <div id="content-area" class="flex-1 overflow-y-auto p-4 bg-[#f4f6f9]">
            
            <div id="view-search" class="space-y-4">
                <div class="flex justify-between items-end border-b border-slate-200 pb-2">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center">
                        <i data-lucide="search" class="w-5 h-5 mr-2 text-[#1589ee]"></i>書籍検索
                    </h2>
                </div>

                <div class="bg-white border border-[#d8dde6] rounded p-5 shadow-sm">
                    <div class="flex space-x-3">
                        <div class="flex-1 relative">
                            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                            <input type="text" id="search-input" class="w-full pl-10 pr-4 py-2 border rounded text-xs outline-none bg-slate-50 focus:ring-1 focus:ring-blue-400" placeholder="書名、ISBN、品目コードを入力...">
                        </div>
                        <button onclick="executeSearch()" class="bg-[#1589ee] text-white px-8 py-2 rounded text-xs font-bold hover:bg-[#0070d2] transition-colors">検索実行</button>
                    </div>
                </div>

                <div id="books-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    </div>
            </div>

            <div id="view-detail" class="hidden animate-in fade-in duration-300">
                <button onclick="backToSearch()" class="text-[#1589ee] text-[11px] font-bold flex items-center hover:underline mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5"></i> 書籍検索に戻る
                </button>
                
                <div id="detail-content">
                    </div>
            </div>

        </div>
    </main>

    <!-- javascriptの起動、別ファイルにあり -->
    <script src="assets/js/data.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>