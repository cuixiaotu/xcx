import { Category } from 'category-model.js';
var category = new Category();

Page({

  /**
   * 页面的初始数据
   */
  data: {
    categoryTypeArr:{},
    currentMenuIndex:0,
    loadData:{},
    transClassArr: ['tanslate0', 'tanslate1', 'tanslate2', 'tanslate3', 'tanslate4', 'tanslate5'],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },
  _loadData:function(){
    category.getCategoryType((catagoryData)=>{
      this.setData({
        categoryTypeArr: catagoryData
      })
    //在回调函数中进行对分页详情的方法调用 
      var id = catagoryData[0].id;
      category.getProductsByCategory(id, (data) => {
        var dataObj = {
          products: data,
          topImgUrl: catagoryData[0].topic_img.url,
          title: catagoryData[0].name,
        };
      
        this.setData({
          productsArr: dataObj,
        })
        this.data.loadData[0]=dataObj;
      });

    });
  },
  // 判断当前分类下的商品信息是否被加载
  isLoadedData:function(index){
    if (this.data.loadData[index]){
      return true;
    }
      return false;
  },
  getDataObjForBind: function (index, data) {
    var obj = {},
      arr = [0, 1, 2, 3, 4, 5],
      baseData = this.data.categoryTypeArr[index];
    for (var item in arr) {
      if (item == arr[index]) {
        obj['categoryInfo' + item] = {
          procucts: data,
          topImgUrl: baseData.img.url,
          title: baseData.name
        };

        return obj;
      }
    }
  },
  changeCategory:function(event){
    var id = category.getDataSet(event, 'id');
    var index = category.getDataSet(event,'index');
    //如果第一次请求数据的话
    if (!this.isLoadedData(index)){ 
    category.getProductsByCategory(id, (data) => {
      var dataObj = {
        products: data,
        topImgUrl: this.data.categoryTypeArr[index].topic_img.url,
        title: this.data.categoryTypeArr[index].name,
      };
      this.setData({
        productsArr: dataObj,
        currentMenuIndex:index,
      })
      this.data.loadData[index] = dataObj;
    })

    }else{
      this.setData({
        productsArr: this.data.loadData[index]
    })
    }
  },
  onProductsItemTap:function(event){
    var id = category.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id='+id,
    })

  }

 


})