import * as express from 'express'
import * as githubController from '../controllers/api/github-controller'

let router = express.Router();

router.get('/github/links', githubController.getLinks);
router.get('/github/exchange', githubController.getExchange);

export = router;