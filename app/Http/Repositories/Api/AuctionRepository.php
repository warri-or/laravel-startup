<?php

namespace App\Http\Repositories\Api;


use App\Http\Repositories\BaseRepository;
use App\Models\Auction\Auction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionRepository extends BaseRepository {
    /**
     * Instantiate repository
     *
     * @param Api/Auction $model
     */
    public function __construct(Auction $model) {
        parent::__construct($model);
    }

    // Your methods for repository

    public function getAuctionList($search_array = [], $where = [], $type = NULL) {
         $query = $this->model::select('auctions.id','auctions.base_price','auctions.bid_increment',
            'auctions.start_date','auctions.end_date', 'auctions.winnig_position', 'auctions.winner_id',
            'auctions.highest_bid', 'auctions.has_live', 'auctions.live_start_time', 'auctions.live_duration',
            'auctions.is_featured', 'auctions.live_end_time', 'auctions.live_final_end_time',
            'auctions.terms_condition', 'auctions.shipping_payment','auctions.status','products.id as product_id',
            'products.name', 'products.slug', 'products.description as product_description','products.is_new',
            'products.additional_info as product_additional_info', 'products.seller_id', 'users.name as seller_name',
            'products.price_range_from', 'products.price_range_to',
            'product_combinations.media_url as product_image', 'auction_favourites.is_favourite',
             'categories.name AS category_name'
        );
         $query->join('products', 'auctions.product_id', '=', 'products.id');
         $query->leftJoin('users', 'products.seller_id', '=', 'users.id');
         $query->leftJoin('auction_favourites', 'auctions.id', '=', 'auction_favourites.auction_id');
         $query->leftJoin('product_categories', 'products.id', '=', 'product_categories.product_id');
         $query->leftJoin('categories', function ($join) {
            $join->on('product_categories.category_id', '=', 'categories.id')->where('categories.parent_id', 0);
        });
         $query->leftJoin('product_combinations', function ($join) {
            $join->on('products.id', 'product_combinations.product_id')
                 ->where('product_combinations.is_featured', ACTIVE);
        });

         if (isset($search_array['live_start_time']) && !empty($search_array['live_start_time'])){
             $query->where(DB::raw("DATE(auctions.live_start_time)"), $search_array['live_start_time']);
         }
         $this->prepareQueryByType($query,$type);
         $this->prepareSearchQuery($query,$search_array);
         !empty($where) ? $query->where($where) : $query;
         $query->orderBy('auctions.id', 'desc');
         $query->groupBy('products.id');
         return $query->paginate(AUCTION_PAGINATE);
    }

    private function prepareSearchQuery($query,$data){
        if (isset($data['keywords']) && !empty($data['keywords'])) {
            $query->leftJoin('product_tags', 'products.id','product_tags.product_id');
            $query->leftJoin('tags', 'product_tags.tag_id','tags.id');
            $keywords = strtolower($data['keywords']);
            $query->where(function ($search_query) use ($keywords) {
                $search_query->where('products.name', 'like', '%' . $keywords . '%')
                             ->orWhere('products.slug', 'like', '%' . $keywords . '%')
                             ->orWhere(function ($category_query) use ($keywords) {
                                 $category_query->where('categories.name','like','%'.$keywords.'%');
                             })
                             ->orWhere(function ($tag_query) use ($keywords) {
                                 $tag_query->where('categories.name','like','%'.$keywords.'%');
                             });
            });
        }
    }

    private function prepareQueryByType($query,$type){
        if (!empty($type)) {
            if ($type == 'today_auctions') {
                 $query->where(DB::raw("DATE(auctions.live_start_time)"), date('Y-m-d'));
            } else if ($type == 'featured') {
                 $query->where(['auctions.is_featured' => TRUE]);
            } else if ($type == 'is_new') {
                 $query->where(['products.is_new' => TRUE]);
            } else if ($type == 'is_favourite') {
                 $query->where(['auction_favourites.user_id' => Auth::user()->id , 'is_favourite' => TRUE]);
            }elseif ($type == 'my_active_bids') {
                $dt = Carbon::now()->toDateString();
                 $query->join('auction_details',function ($inner_join){
                    $inner_join->on('auctions.id','auction_details.auction_id')
                               ->where('auction_details.bidder_id',Auth::user()->id);
                });
                 $query->where('auctions.live_end_time','>=',$dt);
            }elseif ($type == 'my_expired_bids') {
                $dt = Carbon::now()->toDateString();
                 $query->join('auction_details',function ($inner_join){
                    $inner_join->on('auctions.id','auction_details.auction_id')
                               ->where('auction_details.bidder_id',Auth::user()->id);
                });
                 $query->where('auctions.live_end_time','<',$dt);
            }elseif ($type == 'my_own_bids') {
                 $query->where('auctions.winner_id',Auth::user()->id);
            }elseif ($type == 'my_auctions') {
                 $query->where(['products.seller_id'=>Auth::user()->id]);
            }elseif ($type == 'my_approved_auctions') {
                 $query->where(['products.seller_id'=>Auth::user()->id,'auctions.status'=>ACTIVE]);
            }elseif ($type == 'my_pending_auctions') {
                 $query->where(['products.seller_id'=>Auth::user()->id,'auctions.status'=>INACTIVE]);
            }elseif ($type == 'my_live_items') {
                 $query->where(['products.seller_id'=>Auth::user()->id,'auctions.status'=>AUCTION_IN_LIVE]);
            }elseif ($type == 'my_sold_items') {
                 $query->where(['products.seller_id'=>Auth::user()->id])->where('auctions.status','>=',SOLD);
            }
        }
    }

    public function getAuctionDetails($slug) {
        return $this->model::select('auctions.id','auctions.base_price','auctions.bid_increment',
            'auctions.start_date','auctions.end_date','auctions.service_charge', 'auctions.winnig_position', 'auctions.winner_id',
            'auctions.highest_bid', 'auctions.has_live', 'auctions.live_start_time', 'auctions.live_duration',
            'auctions.is_featured', 'auctions.live_end_time', 'auctions.live_final_end_time',
            'auctions.terms_condition', 'auctions.shipping_payment','auctions.status','products.id as product_id',
            'products.name', 'products.slug', 'products.description as product_description','products.is_new',
            'products.additional_info as product_additional_info', 'products.seller_id', 'users.name as seller_name',
            'product_pricings.price_range_from', 'product_pricings.price_range_to',
            'product_combinations.media_url as product_image', 'auction_favourites.is_favourite',
            DB::raw("GROUP_CONCAT(categories.name) AS category_name")
        )->join('products', 'auctions.product_id', 'products.id')
       ->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
       ->leftJoin('product_brands', 'products.id', '=', 'product_brands.product_id')
       ->leftJoin('brands', 'product_brands.product_id', '=', 'brands.id')
       ->leftJoin('users', 'products.seller_id', '=', 'users.id')
       ->leftJoin('auction_favourites', 'auctions.id', '=', 'auction_favourites.auction_id')
       ->leftJoin('product_categories', 'products.id', '=', 'product_categories.product_id')
       ->leftJoin('categories', function ($join) {
           $join->on('product_categories.category_id', '=', 'categories.id')
                ->where('categories.parent_id', 0);
       })
       ->leftJoin('product_combinations', function ($join) {
            $join->on('products.id', 'product_combinations.product_id')
                 ->where('product_combinations.is_featured', ACTIVE);
        })->where('products.slug', $slug)->first();
    }
}


