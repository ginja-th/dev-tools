import { RequestHandler, Request, Response, NextFunction } from "express";

/**
 * 
 * @param req 
 * @param res 
 * @param next 
 */
let getPullRequest: RequestHandler = (req: Request, res: Response, next: NextFunction) => {
  return res.json({
    status: "Okie dokie"
  })
}

/**
 * 
 * @param req 
 * @param res 
 * @param next 
 */
let postPullRequest: RequestHandler = (req: Request, res: Response, next: NextFunction) => {
  return res.json({
    status: "Okie dokie"
  })
}

let actions = {
  getPullRequest,
  postPullRequest
}

export = actions