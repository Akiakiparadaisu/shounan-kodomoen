# 湘南こども園 テーマ

[湘南こども園](https://shounankodomoen.jp/wp4/wp/) 公式サイトのリニューアル用カスタムテーマです。

## 使い方

1. WordPress 管理画面 → **外観 → テーマ** で「湘南こども園」を有効化
2. 有効化時に主要固定ページ・メニューが自動作成されます
3. **設定 → 一般** でサイト名が「湘南こども園」になっていることを確認
4. 写真は `assets/images/` の仮SVGを、メディアライブラリの実写真に差し替えてください

## 主なファイル

- `front-page.php` … トップページ構成
- `page.php` / `single.php` … 下層・お知らせ
- `assets/css/main.css` … デザイン本体
- `assets/images/photos/` … メニュー対応の写真フォルダ（`MENU-MAP.txt` 参照）
- 各フォルダ内の `{スラッグ}.svg` … 仮画像（同名の jpg/png/webp で差し替え）

## メニュー位置

- グローバルナビ（primary）
- フッターナビ（footer）
- モバイルナビ（mobile）
