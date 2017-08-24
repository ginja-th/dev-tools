import * as express from 'express'
import * as githubController from '../controllers/webhooks/github-controller'

let router = express.Router()

router.get('/github/pull-request', githubController.getPullRequest)
router.post('/github/pull-request', githubController.postPullRequest)

// router.get('/github/tokens', githubController.getTokens)
// router.get('/github/tokens/exchange', githubController.getTokensExchange)

export = router