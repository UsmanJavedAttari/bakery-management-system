import { BehaviorSubject } from 'rxjs';
import { CartItemApi } from '@/sdk/api-services';
import { LoaderService } from '../shared/loader.service';
import { CoreService } from '../shared/core.service';
import { CartItemModel } from '@/sdk/models';
import { ProductService } from '../product/product.service';
import VueRouter from 'vue-router';

export class CartItemService {
  private static _Instance: CartItemService;
  public static get Instance() {
    if (!this._Instance) {
      this._Instance = new CartItemService();
    }
    return this._Instance;
  }
  private constructor() {}

  // Services
  private LoaderService = LoaderService.Instance;

  // APIs
  private CartItemApi = new CartItemApi();

  // Cart Items Count
  public CartItemsCount = new BehaviorSubject<{ NumberOfItems: number }>({
    NumberOfItems: 0
  });
  public getCartItemsCount() {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.getCartItemsCount().subscribe(
      ({ Data }) => {
        this.CartItemsCount.next(Data);
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        this.LoaderService.hideFullScreenLoader();
        CoreService.showAlert(err, 'error');
      }
    );
  }

  // Total Amount
  public TotalAmount = new BehaviorSubject(0);
  public getTotalAmount() {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.getTotalAmount().subscribe(
      ({ Data }) => {
        this.TotalAmount.next(+Data);
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        this.LoaderService.hideFullScreenLoader();
        CoreService.showAlert(err, 'error');
      }
    );
  }

  // Cart Items
  public CartItems = new BehaviorSubject<Array<CartItemModel>>([]);
  public getCartItems() {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.getCartItems().subscribe(
      ({ Data }) => {
        this.CartItems.next(Data);
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        this.LoaderService.hideFullScreenLoader();
        CoreService.showAlert(err, 'error');
      }
    );
  }

  // Add to Cart
  public addToCart(productId: string, dec = false, msg?: string) {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.addToCart(productId, dec).subscribe(
      () => {
        this.getCartItemsCount();
        this.getCartItems();
        ProductService.Instance.getProducts();
        this.LoaderService.hideFullScreenLoader();
        if (msg) {
          CoreService.showAlert(msg, 'success');
        }
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }

  // Remove item
  public removeItem(productId: string) {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.removeItem(productId).subscribe(
      () => {
        this.getCartItemsCount();
        this.getCartItems();
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }

  // Checkout
  public checkout(paymentCardNumber: string, $router: VueRouter) {
    this.LoaderService.showFullScreenLoader();
    this.CartItemApi.checkout(paymentCardNumber).subscribe(
      () => {
        $router.push({ name: 'Payment Invoices' });
        this.getCartItemsCount();
        this.getCartItems();
        this.LoaderService.hideFullScreenLoader();
      },
      err => {
        CoreService.showAlert(err, 'error');
        this.LoaderService.hideFullScreenLoader();
      }
    );
  }
}
