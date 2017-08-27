import * as request from 'request-promise-native';

const endpoint: string = 'https://github.com/';

export class Github {

  /**
   * Get a Github user's profile given an access token.
   * @param accessToken 
   */
  getUser(accessToken: string): Promise<any> {
    
    let url = 'https://api.github.com/user?access_token=' + accessToken;

    return request.get(url, {
      headers: {
        'user-agent': 'node.js'
      }
    });
  }
  
  /**
   * Exchange a temporary "code" for an access token.
   * @param code 
   */
  exchangeCode(code: string): Promise<any> {
    
    let url = endpoint + '/login/oauth/access_token';

    let json = {
      client_id: process.env.GITHUB_CLIENT_ID,
      client_secret: process.env.GITHUB_CLIENT_SECRET,
      code: code,
      accept: 'json'
    };

    return request.post(url, {
      json,
      headers: {
        'user-agent': 'node.js'
      }
    }).then((parsedBody) => {
    
      console.log('github.ts::exchangeCode() - ', parsedBody);
      return parsedBody.access_token;
    
    }).catch(() => {
      
      return null;

    });
    
  }
};