/**
 * K-Next+ アプリケーションロジック
 * 画面制御、データ描画、チャート生成を担当します。
 */

let chartInstance = null; // グラフの重複描画を防ぐためのインスタンス保持

// ページ読み込み完了時に初期化
document.addEventListener('DOMContentLoaded', () => {
    renderSearchGrid();
    lucide.createIcons(); // アイコンの初期化
});

/**
 * 1. 書籍検索グリッドの描画
 */
function renderSearchGrid() {
    const grid = document.getElementById('books-grid');
    if (!grid) return;

    // data.js の masterBooks を使用してHTMLを生成
    grid.innerHTML = masterBooks.map(book => `
        <div onclick="showDetail('${book.id}')" class="bg-white border border-[#d8dde6] rounded-sm p-4 hover:shadow-md cursor-pointer transition-all group relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-${book.color}-500 group-hover:w-2 transition-all"></div>
            <div class="flex justify-between items-start mb-3">
                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded uppercase tracking-tighter italic">ID: ${book.id}</span>
                <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-[#1589ee] transition-colors"></i>
            </div>
            <h3 class="text-xs font-black text-slate-700 mb-4 leading-relaxed h-8 overflow-hidden">${book.title}</h3>
            <div class="flex items-center space-x-2">
                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200">${book.genre}</span>
                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-[#1589ee] border border-blue-100">${book.target}</span>
            </div>
        </div>
    `).join('');
    
    lucide.createIcons();
}

/**
 * 2. 画面切り替え（検索 ↔ 詳細）
 */
function showDetail(bookId) {
    const book = masterBooks.find(b => b.id === bookId);
    if (!book) return;

    // ビューの切り替え
    document.getElementById('view-search').classList.add('hidden');
    document.getElementById('view-detail').classList.remove('hidden');
    
    // パンくずリスト（「ユーザーが今、サイト内のどの階層にいるか」を視覚的に示す誘導ナビゲーション）の更新
    document.getElementById('breadcrumb').innerText = `宣伝 ＞ 書籍検索 ＞ ${book.title}`;

    // 詳細コンテンツの描画（元のHTMLから移植）
    renderDetailContent(book);
    
    // アイコンとグラフの初期化
    lucide.createIcons();
    setTimeout(() => initChart(), 100); // 描画完了を待ってからグラフ作成
}

function backToSearch() {
    document.getElementById('view-search').classList.remove('hidden');
    document.getElementById('view-detail').classList.add('hidden');
    document.getElementById('breadcrumb').innerText = "宣伝 ＞ 書籍検索";
}

/**
 * 3. 詳細画面のコンテンツ描画
 * ※HTMLが長いため、主要な構造のみ記述。本来はここもさらに部品化可能です。
 */
function renderDetailContent(book) {
    const container = document.getElementById('detail-content');
    // ここに元のHTMLの詳細画面部分のテンプレートを流し込みます
    // (※簡略化のため、元のHTMLの構造を維持したまま変数 ${book.title} 等を埋め込みます)
    container.innerHTML = `
        <div class="bg-white border border-[#d8dde6] rounded-sm shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#d8dde6] bg-slate-50">
                <h2 class="text-xl font-black text-slate-800">${book.title}</h2>
            </div>
            <div class="p-6">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    `;
    // ※ 実際の運用では、ここをさらに細かくHTMLパーツとして分けるのが理想です
}

/**
 * 4. グラフ(Chart.js)の初期化
 */
function initChart() {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    if (chartInstance) {
        chartInstance.destroy(); // 既存のグラフを破棄してメモリリーク防止
    }

    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['07/01', '07/02', '07/03', '07/04', '07/05', '07/06', '07/07', '07/08', '07/09', '07/10', '07/11', '07/12', '07/13', '07/14', '07/15'],
            datasets: [
                { label: '実売数', data: [120, 135, 128, 142, 190, 210, 205, 185, 170, 165, 180, 220, 310, 450, 480], borderColor: '#1589ee', tension: 0.3, fill: true, backgroundColor: 'rgba(21, 137, 238, 0.1)' },
                { label: '在庫数', data: [800, 785, 770, 750, 720, 700, 680, 660, 645, 630, 615, 600, 580, 550, 520], borderColor: '#f44336', borderDash: [5, 5], tension: 0, yAxisID: 'y1' }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true },
                y1: { position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });
}