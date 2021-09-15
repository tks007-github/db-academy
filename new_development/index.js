$(function() {
    // 隠したい要素
    var hideSelector = ".p-1, .p-3";
  
    // 印刷前のイベント
    window.onbeforeprint = function() {
      // 要素を非表示
      $(hideSelector).hide();
    }
  
    // 印刷後のイベント
    window.onafterprint = function() {
      // 要素を表示
      $(hideSelector).show();
    }
  });