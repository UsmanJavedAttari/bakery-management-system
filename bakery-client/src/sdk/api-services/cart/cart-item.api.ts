import { BaseApi } from '../base.api';
import { Observable } from 'rxjs';
import { CartItemModel } from '@/sdk/models';

export class CartItemApi extends BaseApi {
  public getCartItemsCount(): Observable<ApiRes<{ NumberOfItems: number }>> {
    return this.GET_Request(
      `${this.ApiUrl}/cartitem/count-cart-items.php?customerId=${this.ApiAuth.SessionValue?.Id}`
    );
  }
  public getCartItems(): Observable<ApiRes<Array<CartItemModel>>> {
    return this.GET_Request(
      `${this.ApiUrl}/cartitem/get-cart-items.php?customerId=${this.ApiAuth.SessionValue?.Id}`
    );
  }
  public addToCart(ProductId: string, Dec = false): Observable<ApiRes> {
    return this.POST_Request(`${this.ApiUrl}/cartitem/add-to-cart.php`, {
      CartId: this.ApiAuth.SessionValue?.CartId,
      ProductId,
      Dec
    });
  }
  public removeItem(ProductId: string): Observable<ApiRes> {
    return this.DELETE_Request(
      `${this.ApiUrl}/cartitem/remove-item.php?CartId=${this.ApiAuth.SessionValue?.CartId}&ProductId=${ProductId}`
    );
  }
  public getTotalAmount(): Observable<ApiRes<number>> {
    return this.GET_Request(
      `${this.ApiUrl}/cartitem/get-total-amount.php?CartId=${this.ApiAuth.SessionValue?.CartId}`
    );
  }
  public checkout(PaymentCardNumber: string): Observable<ApiRes> {
    return this.POST_Request(`${this.ApiUrl}/cartitem/checkout.php`, {
      PaymentCardNumber,
      CustomerId: this.ApiAuth.SessionValue?.Id
    });
  }
}
