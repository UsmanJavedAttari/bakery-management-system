import { BehaviorSubject } from 'rxjs';
import { ProductCategoryModel, ProductModel } from '@/sdk/models';
import { ProductApi } from '@/sdk/api-services';
import { LoaderService } from '../shared/loader.service';
import { CoreService } from '../shared/core.service';

export class ProductService {
  private static _Instance: ProductService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new ProductService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Services
  private LoaderService = LoaderService.Instance;

  // APIs
  private ProductApi = new ProductApi();

  // Product Categories
  public ProductCategories = new BehaviorSubject<ProductCategoryModel[]>([]);
  public getProductCategories() {
    this.LoaderService.showFullScreenLoader();
    this.ProductApi.getProductCategories().subscribe(
      ({ Data }) => {
        this.ProductCategories.next([
          { Id: '', Title: 'All', Description: null },
          ...Data
        ]);
        this.LoaderService.hideFullScreenLoader();
      },
      () => {
        this.LoaderService.hideFullScreenLoader();
        CoreService.showAlert('Unable to load product categories', 'error');
      }
    );
  }

  // Product Categories
  public Products = new BehaviorSubject<Array<ProductModel>>([]);
  public getProducts(loaderState = true) {
    this.LoaderService.showFullScreenLoader(undefined, loaderState);
    this.ProductApi.getProducts(
      this._Search,
      this._SelectedProductCategory
    ).subscribe(
      ({ Data }) => {
        this.LoaderService.hideFullScreenLoader(loaderState);
        this.Products.next(Data);
      },
      () => {
        this.LoaderService.hideFullScreenLoader(loaderState);
        CoreService.showAlert('Unable to load products', 'error');
      }
    );
  }

  // Search Product Category
  private _Search = '';
  get Search() {
    return this._Search;
  }
  set Search(query: string) {
    this._Search = query;
    this.getProducts(false);
  }

  // Selected Product Category
  private _SelectedProductCategory = '';
  get SelectedProductCategory() {
    return this._SelectedProductCategory;
  }
  set SelectedProductCategory(catId: string) {
    this._SelectedProductCategory = catId;
    this.getProducts();
  }
}
