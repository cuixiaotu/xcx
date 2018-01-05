import { Base } from '../../utils/base.js';

class Category extends Base {

  constructor() {
    super();
  }
  /*获取所有分类下的商品*/
  getCategoryType(callback) {
    var params = {
      url: "category/all",
      sCallback: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
  /*获取某个分类下的商品信息*/
  getProductsByCategory(id, callback) {
    var params = {
      url: "product/category_id?id=" + id,
      sCallback: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
}
export { Category }
