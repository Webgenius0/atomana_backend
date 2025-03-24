SELECT
	st.user_id,
    st.business_id,
    st.closing_date,
    st.purchase_price,
    st.commission_on_sale,
    st.override_split,
    st.business_id,
    t.from,
    t.to,
    t.deduct,
    -- Calculate getting after commission
    (st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100) AS getting,
    -- Determine cutoff (override_split or tier deduct)
    CASE
        WHEN st.override_split IS NOT NULL THEN st.override_split
        ELSE (
            SELECT t.deduct
            FROM tiers t
            WHERE t.business_id = st.business_id
            AND st.purchase_price >= t.from
            AND (st.purchase_price <= t.to OR t.to IS NULL)
            LIMIT 1
        )
    END AS cutoff,
    -- Calculate new getting after applying the deduct from the tier
    CASE
        WHEN st.override_split IS NULL THEN (
            (st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100) - (
                (
                    CASE
                        WHEN st.override_split IS NOT NULL THEN st.override_split
                        ELSE (
                            SELECT t.deduct
                            FROM tiers t
                            WHERE t.business_id = st.business_id
                            AND st.purchase_price >= t.from
                            AND (st.purchase_price <= t.to OR t.to IS NULL)
                            LIMIT 1
                        )
                    END * (st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100)
                ) / 100
            )
        )
        ELSE (st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100)
    END AS new_getting,
    -- Calculate the agent split percentage
    CASE
        WHEN st.override_split IS NULL THEN (
            ((st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100) - (
                (
                    CASE
                        WHEN st.override_split IS NOT NULL THEN st.override_split
                        ELSE (
                            SELECT t.deduct
                            FROM tiers t
                            WHERE t.business_id = st.business_id
                            AND st.purchase_price >= t.from
                            AND (st.purchase_price <= t.to OR t.to IS NULL)
                            LIMIT 1
                        )
                    END * (st.purchase_price - (st.commission_on_sale * st.purchase_price) / 100)
                ) / 100
            )) * 100
        ) / st.purchase_price
        ELSE 0
    END AS agent_split
FROM sales_tracks st
LEFT JOIN tiers t ON st.business_id = t.business_id
WHERE st.purchase_price IS NOT NULL
AND st.status = 'close'
AND st.user_id = 11
AND st.closing_date BETWEEN '2025-02-03' AND NOW();
;  -- Filter for 'close' status
