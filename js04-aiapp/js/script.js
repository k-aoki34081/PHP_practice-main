// 【自分用】ここを見て、javascriptの構成要素を確認 https://docs.google.com/document/d/18BUIxNZs-fv-Ulwo0s86ptLSimjXxnmIyXwrHyi-6x4/edit?tab=t.0

// 【準備】設定ファイル(config.js)から、自分専用の「Gemini APIキー」を読み込みます
import { GEMINI_API_KEY } from './config.js';
// 【準備】Googleが提供している「SDK（Software Development Kit：ソフトウェア開発キット）」をインターネットから取り込みます
import { GoogleGenerativeAI } from 'https://esm.run/@google/generative-ai';

// genAI という定数が、GoogleGenerativeAIを有効化したものとして定義する。
// これを定義することで、プログラミング内でgenAIを用いて、geminiのＳＤＫを使えるようになる。
const genAI = new GoogleGenerativeAI(GEMINI_API_KEY);
// genAI という定数は、GoogleGenerativeAI (設計図/クラス): 「AIを動かすにはどうすればいいか」という知識が詰まったマニュアルのようなものです。
// これ単体では動きません。GEMINI_API_KEY (材料/データ): そのマニュアルを実行するために必要な「鍵」です。
// new (製造命令/演算子): 設計図と材料をガッチャンコして、実物を作り出すアクションです。


// 【動作】画面の「送信」ボタンが押された時の処理をここに書きます
$('#send').on('click', async function () {
    //     async は Asynchronous（非同期） の略です。
    // 普通の関数: 上から下へ、一行ずつ順番に「絶対に」実行します。前の仕事が終わるまで次へ進めない。
    // async 関数: 「あ、これは時間がかかるな」という仕事に出会ったとき、一時停止して待つことができる特殊な関数になります。

    // 1. 入力欄（テキストエリア）に書かれた本の名前を取得します
    const bookTitle = $('#user-input').val();
    // jQueryでは、.○○（）＝中身を取得する、.○○（▲▲）＝▲▲に書き変える という意味になる。

    // もし何も入力されていなければ（条件の内容（! は「打ち消し」の記号））、ここで処理をストップ（関数の実行をその場で終わらせる命令：戻り値とする。）します
    if (!bookTitle) return;

    // 次の入力のために、入力欄を一旦空っぽにします
    $('#user-input').val('');

    // 画面のAI回答エリア（response）に「検索中」と表示して、動いていることを伝えます
    $('#response').html('📖 本の情報をデータベースで探しています...');

    try {
        // 2. 【外部連携】Googleの「本の図書館API」に、入力されたタイトルで問い合わせます
        // ※これは「非AI型」のAPIで、正確な本のデータを取得するために使います
        const booksResponse = await axios.get('https://www.googleapis.com/books/v1/volumes', {
            params: { q: bookTitle }
        });
        // 1. try { ... } の意味： 「とりあえずやってみる」
        // 役割: 「今から失敗するかもしれない作業（通信）をするけど、もし失敗してもプログラムを強制終了させずに、ちゃんとエラー対応するよ！」という宣言です。
        // ペア: 必ず後半にある catch とセットで使います。

        // 2. axios.get(...) の意味： 「図書館へのリクエスト」
        // .get('https://www.googleapis.com/books/v1/volumes', {
        //             params: { q: bookTitle } 
        //         }); ⇒GOOGLE BOOKS APIのURLのうしろに、params:｛｝と付けることで、URLの住所の後ろに処理を書き足せる。
        // 具体的にはqという検索ワードラベルを設定して、前に定数で定義したbookTitle = $('#user-input').val();を探せとする。




        // もし本が1冊も見つからなかった場合の処理です
        if (!booksResponse.data.items || booksResponse.data.items.length === 0) {
            $('#response').html('その本は見つかりませんでした。別の名前を試してください。');
            return;
        }
        // !booksResponse.data.items ： booksResponseの操作自体キャンセルされていたら
        // ｜｜＝または
        // booksResponse.data.items.length === 0 ：booksResponseの操作自体はできたけど、検索結果０なら。

        // 見つかった本の中から「正式なタイトル」と「内容（あらすじ）」を抜き出します
        const book = booksResponse.data.items[0].volumeInfo;
        // 一番関連度が高い0番目の本に関して、.volumeInfo（本の詳細情報を指定）
        const title = book.title;
        // 上記book変数のタイトルを抜き出す変数を、titleと設定。
        const description = book.description || "あらすじ情報がありません。";
        // descriptionという変数を設定して、もしbookのあらすじを取り出す、もしなかったときは、あらすじは有りませんと表示する。

        // 進行状況を画面に表示します。タイトルが見つかれば、この表示をします。
        $('#response').html(`🔎 「${title}」が見つかりました。AIが性格分析を行っています...`);

        // 3. 【AI連携】手に入れた「あらすじ」をAIに渡して、性格診断を依頼します
        await callGeminiAPI(title, description);
        //         await	「待機」の命令	AIが答えを書き終わって戻ってくるまで、ここで待つ
        // callGeminiAPIという関数の呼び出し	AIと通信するために自分で作った「専用の手順書（関数）」を実行する
        // (title, description)	引数（ひきすう）	AIに渡すための「お土産（材料）」。具体的な本の名前と内容

    } catch (error) {
        // インターネット接続が切れた時などのエラー処理です
        console.error("エラー:", error);
        $('#response').html('エラーが発生しました。インターネット接続を確認してください。');
    }
});

// try { ... } とセットで動く**「トラブル発生時のためのバックアッププラン（例外処理）」**です。
// catch: 「（エラーを）捕まえる」という意味です。

// (error): 発生したエラーの詳しい内容（原因など）がこの変数の中に自動的に入ります。
// 2. console.error("エラー:", error); ： 開発者へのメモ
// 役割: ブラウザの裏側（コンソール）に、エラーの正体を書き出します。
// 意味: 画面上には見えませんが、プログラミングをしているあなたが「なぜ動かなかったのか？」を分析するための、**「現場検証の記録」**のようなものです。

/**
 * AI（Gemini）に具体的な性格分析を依頼する関数です
 */
async function callGeminiAPI(title, description) {
    try {
        // 使用するAIモデルを指定します。404エラーを防ぐため最も安定した名前を使います
        const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

        // AIへの「指示書（プロンプト）」を組み立てます。プロンプトはAIに指示する日本語のこと。プログラミング言語で指示するのとは別。
        const prompt = `
あなたは心理学と性格診断システム「スローン法（SLOAN / Global 5）」の熟練した専門家です。
以下の本の内容を深く読み解き、この本を愛読する人の性格をスローン法で精密にプロファイリングしてください。

【対象とする本】
タイトル：${title}
あらすじ：${description}

【出力の構成ルール】
以下の項目を順番に出力してください。

1. **診断コード**: 
スローンの32タイプ（例：RCUAI, SLOEN, RCOENなど）から、最もふさわしい「5文字のコード」を1つ特定してください。

2. **性格のキャッチコピー**:
そのタイプの性質を、この本の読者層に合うような魅力的な二つ名（例：「好奇心旺盛な自由人」「静かなる戦略家」など）で表現してください。

3. **詳しい性格分析（200文字程度）**:
ビッグファイブの5つの指標（S/R, L/C, O/U, A/E, N/I）に基づき、なぜこの本を好む人がその特性を持つと言えるのか、心理的な動機や価値観を解説してください。

4. **読者へのアドバイス**:
その性格タイプの人に向けた、日常をより良くするための短いメッセージ。

【制約事項】
- 必ず「あなたの性格タイプは【〇〇〇〇〇】です」という一文から始めてください。
- 親しみやすくも、知的なトーンで回答してください。
`;
        // このように日本語のプロンプトを prompt という変数でプログラミング言語に組み込む。

        // 指示書をAIに送り、回答が届くのを待ちます
        const result = await model.generateContent(prompt);
        // 前にmodelという変数でgeminiを割り当てているので、そのモデルがプロンプトから文章を生成するのを待つ。
        const airesponse1 = await result.response;
        // aiの返答という変数を置いて、result変数の.responseという場所に回答データがあるのでそれを表すことにします。
        const aiResponse2 = airesponse1.text(); // AIの言葉をテキストとして取り出したものをaiResponse2と置きます。

        // AIの回答を表示します（改行を見やすく調整します）
        $('#response').html(aiResponse2.replace(/\n/g, '<br>'));
// /\n/gは、「すべての（g）改行（\n）を見つけて」という特別な書き方（正規表現）、AIの改行をHTMLの改行<br>に直す。
    } catch (error) {
        // APIキーが間違っている、または制限がかかった時のエラー処理です
        console.error("AIエラー:", error);
        $('#response').html('AI解析中にエラーが起きました。APIキーが正しいか、設定を確認してください。');
    }
}