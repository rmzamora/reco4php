<?php

/**
 * This file is part of the GraphAware Reco4PHP package.
 *
 * (c) GraphAware Limited <http://graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Reco4PHP\Engine;

use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Type\Node;
use GraphAware\Common\Result\ResultCollection;
use GraphAware\Reco4PHP\Context\Context;
use GraphAware\Reco4PHP\Result\Recommendations;
use GraphAware\Reco4PHP\Result\SingleScore;

interface DiscoveryEngine
{
    /**
     * @return string The name of the discovery engine
     */
    public function name() : string;

    /**
     * The statement to be executed for finding items to be recommended.
     *
     * @param Node    $input
     * @param Context $context
     *
     * @return \GraphAware\Common\Cypher\Statement
     */
    public function discoveryQuery(Node $input, Context $context) : StatementInterface;

    /**
     * Returns the score produced by the recommended item.
     *
     * @param Node    $input
     * @param Node    $item
     * @param Record  $record
     * @param Context $context
     *
     * @return \GraphAware\Reco4PHP\Result\SingleScore A single score produced for the recommended item
     */
    public function buildScore(Node $input, Node $item, Record $record, Context $context) : SingleScore;

    /**
     * Returns a collection of Recommendation object produced by this discovery engine.
     *
     * @param Node             $input
     * @param ResultCollection $resultCollection
     * @param Context          $context
     *
     * @return Recommendations
     */
    public function produceRecommendations(Node $input, ResultCollection $resultCollection, Context $context) : Recommendations;

    /**
     * @return string The column identifier of the row result representing the recommended item (node)
     */
    public function recoResultName() : string;

    /**
     * @return string The column identifier of the row result representing the score to be used, note that this
     *                is not mandatory to have a score in the result. If empty, the score will be the float value returned by
     *                <code>defaultScore()</code> or the score logic if the concrete class override the <code>buildScore</code>
     *                method.
     */
    public function scoreResultName() : string;

    /**
     * @return float The default score to be given to the discovered recommended item
     */
    public function defaultScore() : float;
}
