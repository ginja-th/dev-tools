import { RequestHandler, Request, Response, NextFunction } from "express";
import * as api from '../../helpers/api';
import { Github } from '../../integrations/github';

export interface IGithubLinks {
  redirect: string;
};

/**
 * 
 * @param req 
 * @param res 
 * @param next 
 */
export var getLinks: RequestHandler = (req: Request, res: Response, next: NextFunction) => {
  
  let links: IGithubLinks = {
    redirect: 'https://github.com/login/oauth/authorize?scope=user:email&client_id=' + process.env.GITHUB_CLIENT_ID
  };

  return res.json(api.single(links));
}

/**
 * 
 * @param req 
 * @param res 
 * @param next 
 */
export var getExchange: RequestHandler = (req: Request, res: Response, next: NextFunction) => {
  let code = req.param('code');

  if (code) {
    
    let githubApi = new Github();
    return githubApi.exchangeCode(code)
      .then((result) => {
        if (result) {
          
          console.log('Result', result);
          
          return githubApi.getUser(result)
            .then((payload) => {
              console.log('Payload', payload);
              return res.json(api.single(payload));
            });

        } else {
          return res.json(api.invalid({code: 'The code field is invalid.'}));
        }
      });

  } else {
    return res.json(api.invalid({code: "The code field is required."}));
  }

  // return res.json(api.single({
  //   code: req.param('code')
  // }));
};