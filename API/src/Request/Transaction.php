<?php
namespace API\src\Request;

use API\src\Config\Config;

/**
 * Request Transactions
 *
 * This is DISK DEPENDENT code people
 *
 * This class WRITES TO DISK
 *
 * This class WILL WRITE TO DISK
 *
 * WHEN WRITING TO DISK THINGS CAN BE SLOW
 *
 * DID I MENTION THIS WRITES TO DISK?
 *
 * </endrant>
 *
 * Okay seriously, this will only be mildly scalable on a high IOPS disk
 * But works for now, should only cause problems when we get into *billions* mode
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Transaction
{

    /**
     * Microtime when the request transaction object was built
     *
     * @var float
     */
    public $startTime = null;

    /**
     * The actualy request object
     * This will be used to rebuild from transactions in case of major fault
     * DO NOT TOUCH
     *
     * @var Request
     */
    public $request = null;

    /**
     * Same as request ID
     * Just used for data repair
     *
     * @var string
     */
    public $id = null;

    /**
     * The date (folder name) this transaction was stored in
     *
     * @var string
     */
    public $date = null;

    /**
     * Where does our configuration tell us to save these
     *
     * @var string
     */
    public $transactionDirectory;

    /**
     * Easter egg found!
     * All transactions will have this extension appended to their name
     *
     * @var string
     */
    const TRANSACTION_EXTENSION = '.trans'; // Kris >.>
    
    /**
     * Will init and build the transaction
     *
     * @param Request $request            
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->startTime = microtime(1);
        $this->id = $request->id;
        $this->date = date('mdy');
        $this->transactionDirectory = Config::getConfig('TransactionDirectory') . '/' . $this->date;
        if (! file_exists($this->transactionDirectory)) {
            mkdir($this->transactionDirectory, 0744, 1);
        }
        $bytesWritten = $this->build();
    }

    /**
     * Writes the transaction to disk
     *
     * @return number
     */
    public function build()
    {
        $transactionFileName = $this->transactionDirectory . '/' . $this->id . static::TRANSACTION_EXTENSION;
        return file_put_contents($transactionFileName, serialize($this));
    }

    /**
     * Unlinks the transaction from disk
     * 
     * @return bool
     */
    public function destroy()
    {
        $transactionFileName = $this->transactionDirectory . '/' . $this->id . static::TRANSACTION_EXTENSION;
        return unlink($transactionFileName);
    }
}
