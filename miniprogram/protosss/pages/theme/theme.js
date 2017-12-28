// pages/theme/theme.js

import { Theme } from 'theme-model.js';
var theme = new Theme();

Page({

  data: {
  
  },
  onLoad: function (options) {
   var id = options.id;
   var name = options.name;
   this.data.id = id;
   this.data.name = name;
   this._loadData();
  },
  _loadData:function(){
    var id = this.data.id;
  theme.getProductsData(id,(res)=>{
    this.setData({
      themeInfo : res
    })
  }
  )
  },
  onReady:function(){
    wx.setNavigationBarTitle({
      title: this.data.name,
    })
  },
  onProductsItemTap: function (event) {
    var id = theme.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },
 
})