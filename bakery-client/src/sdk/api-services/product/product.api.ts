import { BaseApi } from '../base.api';
import { ProductCategoryModel, ProductModel } from '@/sdk/models';
import { Observable } from 'rxjs';

export class ProductApi extends BaseApi {
  public getProductCategories(): Observable<
    ApiRes<Array<ProductCategoryModel>>
  > {
    return this.GET_Request(`${this.ApiUrl}/productcategory/read.php`);
  }
  public getProducts(
    search: string,
    catId: string
  ): Observable<ApiRes<Array<ProductModel>>> {
    return this.GET_Request(
      `${this.ApiUrl}/product/read.php?productcategory=${catId}&search=${search}`
    );
  }
}
