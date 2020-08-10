import axios, { AxiosError, AxiosRequestConfig, AxiosResponse } from 'axios';
import { Observable, throwError, Observer } from 'rxjs';
import { catchError, delay, map } from 'rxjs/operators';
import { SdkConfig } from '../sdk.config';
import { ApiAuth } from '../core/api.auth';
import { SessionModel } from '../models';

export abstract class BaseApi {
  protected ApiAuth: ApiAuth = ApiAuth.Instance;
  protected ApiUrl = SdkConfig.ApiPath;

  protected request(
    method: AxiosRequestConfig['method'],
    url: string,
    PostBody: AnyObject = {}
  ): Observable<AxiosResponse> {
    // Headers to be sent
    const headers: AxiosRequestConfig['headers'] = {
      Accept: 'application/json',
      'Content-Type': 'application/json;charset=UTF-8'
    };
    const Options: AxiosRequestConfig = {
      method,
      url,
      headers,
      data: PostBody
    };
    return Observable.create((observer: Observer<unknown>) => {
      axios(Options)
        .then((Res: AxiosResponse<ApiRes>) => {
          if (!Res.data.Status) {
            throw new Error(Res.data.Message);
          }
          observer.next(Res);
          observer.complete();
        })
        .catch(err => {
          observer.error(err);
        });
    }).pipe(
      delay(0),
      map(Res => Res),
      catchError(e => this.handleError(e))
    );
  }
  private handleError(error: AxiosError<ApiRes> | Error) {
    let errMsg: string;
    if ((error as AxiosError<ApiRes>).response?.data.Message) {
      errMsg = (error as AxiosError<ApiRes>).response?.data.Message!;
    } else {
      errMsg = error.message;
    }
    return throwError(errMsg || 'Server Error');
  }

  // Requests
  protected GET_Request(Url: string) {
    return this.request('GET', Url).pipe(map(Res => Res.data));
  }
  protected POST_Request(Url: string, PostBody: AnyObject) {
    return this.request('POST', Url, PostBody).pipe(map(Res => Res.data));
  }
  protected PATCH_Request(Url: string, PostBody: AnyObject) {
    return this.request('PATCH', Url, PostBody).pipe(map(Res => Res.data));
  }
  protected PUT_Request(Url: string, PostBody: AnyObject) {
    return this.request('PUT', Url, PostBody).pipe(map(Res => Res.data));
  }
  protected DELETE_Request(Url: string) {
    return this.request('DELETE', Url).pipe(map(Res => Res.data));
  }
}
